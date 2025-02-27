<?php
// src/Controllers/SessionController.php

namespace App\Controllers;

use App\Models\Session;
use App\Models\User;
use DateTime;
use App\Http\Log;

class SessionController extends ModelController
{
    public function createSession($user_id)
    {
        $timezone = New \DateTimeZone('Europe/Amsterdam');
        $session_id = bin2hex(random_bytes(32)); // Create a secure random session ID
        $expires_at = $expires_at = (new \DateTime(timezone: $timezone))->modify('+30 days')->format('Y-m-d H:i:s'); // Session expiration time

        // Create a new session record in the database
        $session = new Session();
        $session->session_id = $session_id;
        $session->user_id = $user_id;
        $session->data = serialize([]);  // Start with empty session data
        $session->expires_at = $expires_at;
        $session->last_activity = (new \DateTime(timezone: $timezone))->format('Y-m-d H:i:s');
        $session->ip_address = $this->getUserIp();  // Store the IP address

        // Set the session ID cookie to persist across pages until the browser is closed
        Log::debug([$session_id, $expires_at, $this->getUserIp(), $user_id]);

        // Save the session
        $test = $session->save();

        setcookie('session_id', $session_id, time() + 3600 * 24 * 30, '/', '', true, true); // 30-day expiration, HttpOnly, Secure

        return $session_id;
    }

    public function sessionExists($session_id)
    {
        $timezone = New \DateTimeZone('Europe/Amsterdam');
        // Retrieve the session from the database
        if ($session_id) {
            $session = Session::select(["session_id" => $session_id]);
            $session = $session[0] ?? null;
        }

        if ($session) {
            $now = time();
            $expires_at = $session->expires_at;

            if ($now > $expires_at) {
                Log::debug([$now, $expires_at, $now > $expires_at]);
                return false; // Session has expired
            }
            // Check if the session IP matches the current user's IP
            if ($session->ip_address !== $_SERVER['REMOTE_ADDR']) {
                // IP mismatch – session may have been hijacked
                return false;
            }
            return $session;
        }

        return false;
    }

    public function updateSessionIp($session_id)
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Retrieve the session and update the IP address
        $session = Session::select(["session_id", $session_id]);
        $session = $session[0] ?? null;
        if ($session) {
            $session->setIpAddress($ip_address);
            $session->setLastActivity(new \DateTime());
            $session->save();
        }
    }

    public function getUserIp()
    {
        // Check if the request is forwarded by a proxy and grab the first IP in the list
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getUserBySession($session_id)
    {
        $session = Session::select(["session_id" => $session_id]);
        $session = $session[0] ?? null;
        if ($session) {
            $user_id = $session->user_id;
            return User::select(["id" => $user_id])[0] ?? null;
        }
        return null;
    }
}