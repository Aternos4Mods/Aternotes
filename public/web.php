<?php

use App\Controllers\SessionController;

require_once __DIR__ . '/../bootstrap.php';

$url = $_SERVER['REQUEST_URI'] ?? 'home';

$session_id = $_COOKIE['session_id'] ?? null;

$sessionController = new SessionController();

$isSessionValid = false;
if ($session_id) {
    // Validate the session
    $isSessionValid = $sessionController->sessionExists($session_id);
}

if (str_starts_with($url, '/dashboard') && !$isSessionValid) {
    header('Location: /login');
    exit;
}

switch ($url) {
    case '/':
        include 'views/home.php';
        break;
    case '/login':
        include 'views/login.php';
        break;
    case '/dashboard':
        include 'views/dashboard/home.php';
        break;
    default:
        include 'views/404.php';
        break;
}
