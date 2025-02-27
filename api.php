<?php
require_once __DIR__ . '/bootstrap.php';
use App\Controllers\LoginController;
use App\Http\Request;

$requestUri = $_SERVER['REQUEST_URI'];
$request = new Request();

switch ($requestUri) {
    case '/api/user':
        $LoginController = new LoginController();
        $LoginController->getUser();
        break;
    case '/api/login':
        $LoginController = new LoginController($request);
        $LoginController->handleRequest($request);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => "{$requestUri} Not found", 'status' => 404]);
        break;
}
