<?php
// src/Controllers/SessionController.php

namespace App\Controllers;

use App\Models\Session;
use DateTime;
use App\Http\Log;

class SessionController extends ModelController
{
    public function createSession($user_id)
    {
        $session_id = bin2hex(random_bytes(32)); // Create a secure random session ID
        $expires_at = (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s'); // Session expiration time

        // Create a new session record in the database
        $session = new Session();
        $session->setSessionId($session_id);
        $session->setUserId($user_id);
        $session->setData(serialize([]));  // Start with empty session data
        $session->setExpiresAt($expires_at);
        $session->setIpAddress($this->getUserIp());  // Store the IP address

        // Set the session ID cookie to persist across pages until the browser is closed
        Log::info('In session controller');

        // Save the session
        $test = $session->save();

        setcookie('session_id', $session_id, time() + 3600 * 24 * 30, '/', '', true, true); // 30-day expiration, HttpOnly, Secure

        return $session_id;
    }

    public function sessionExists($session_id)
    {
        // Retrieve the session from the database
        if ($session_id) {
            $session = Session::select(["session_id", $session_id]);
            $session = $session[0] ?? null;
        }

        if ($session) {
            $now = new \DateTime();
            $expires_at = new \DateTime($session->getExpiresAt());

            if ($now > $expires_at) {
                return false; // Session has expired
            }
            // Check if the session IP matches the current user's IP
            if ($session->getIpAddress() !== $_SERVER['REMOTE_ADDR']) {
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
}