<?php

namespace App\Controllers;

use Dotenv;
use App\Models\User;

abstract class ModelController
{
    protected $data;

    public function __construct()
    {

        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();

        $driver = (new \Aternos\Model\Driver\Mysqli\Mysqli())
            ->setHost($_ENV['DATABASE_HOST'])
            ->setUsername($_ENV['DATABASE_USER'])
            ->setPassword($_ENV['DATABASE_PASSWORD'])
            ->setDatabase($_ENV['DATABASE_NAME']);

        \Aternos\Model\Driver\DriverRegistry::getInstance()->registerDriver($driver);
        // Parse incoming JSON data
        $this->data = json_decode(file_get_contents("php://input"), true);
    }

    public function handleRequest()
    {
        $function = $this->data['function'] ?? null;

        if (isset($function)) {
            if (!method_exists($this, $function)) {
                echo json_encode(['error' => 'Function not found', 'status' => 404]);
                http_response_code(404);
                return;
            }

            $params = $this->data;
            unset($params['function']); // Remove 'function' from the data array

            // Call the method with parameters
            call_user_func_array([$this, $function], $params);
        } else {
            echo json_encode(['error' => 'Function was not passed', 'status' => 404]);
            http_response_code(404);
        }
    }
}
