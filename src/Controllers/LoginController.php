<?php
namespace App\Controllers;

use App\Http\Log;
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

            $_COOKIE['session_id'] = $session_id;

            echo json_encode(['success' => 'User logged in', 'status' => 200]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Password incorrect', 'status' => 401]);
        }
    }

    public function getUser()
    {
        $sessionId = $_COOKIE['session_id'] ?? null;

        if (!$sessionId) {
            http_response_code(401);
            echo json_encode(['error' => 'No session ID was found and user could therefore not be retrieved', 'status' => 401]);
            return;
        }

        $sessionController = new SessionController();
        $user = $sessionController->getUserBySession($sessionId);

        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'No user was found for the given session ID', 'status' => 401]);
            return;
        }

        return $user;
    }
}
