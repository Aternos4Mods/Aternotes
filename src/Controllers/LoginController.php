<?php
namespace App\Controllers;

use App\Models\User;
use App\Http\Request;

class LoginController extends ModelController
{
    public function userHandler(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // Proceed with logic as before
        $user = User::select(['username' => $username]);

        $firstUser = $user[0] ?? null;

        if (!$firstUser) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found', 'status' => 404]);
            return;
        }

        $HashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (password_verify($password, $firstUser->password)) {
            $sessionController = new SessionController();
            $session_id = $sessionController->createSession($firstUser->id);

            $_SESSION['session_id'] = $session_id;

            echo json_encode(['success' => 'User logged in', 'status' => 200]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Password incorrect', 'status' => 401]);
        }
    }
}
