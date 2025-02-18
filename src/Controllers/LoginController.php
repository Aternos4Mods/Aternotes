<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends ModelController
{
    public function userHandler(string $username, string $password)
    {
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
