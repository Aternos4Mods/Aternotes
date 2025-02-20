<?php
namespace App\Controllers;

use App\Models\User;
use App\Http\Request; // Make sure to include the Request class

class LoginController extends ModelController
{
    public function userHandler(Request $request) // Accepting Request object
    {
        $username = $request->username; // Access username from the request data
        $password = $request->password; // Access password from the request data

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
            $_SESSION['user'] = $firstUser->id;
            echo json_encode(['success' => 'User logged in', 'status' => 200]);
        } else {
            echo json_encode(['error' => 'Password incorrect', 'status' => 401]);
            http_response_code(401);
        }
    }
}
