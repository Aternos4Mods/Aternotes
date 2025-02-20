<?php

namespace App\Controllers;

use App\Http\Request;

abstract class ModelController
{
    protected $data;

    public function __construct(Request $request)
    {
        $driver = (new \Aternos\Model\Driver\Mysqli\Mysqli())
            ->setHost($_ENV['DATABASE_HOST'])
            ->setUsername($_ENV['DATABASE_USER'])
            ->setPassword($_ENV['DATABASE_PASSWORD'])
            ->setDatabase($_ENV['DATABASE_NAME']);

        \Aternos\Model\Driver\DriverRegistry::getInstance()->registerDriver($driver);

        $this->data = $request->getData();
    }

    public function handleRequest(Request $request)
    {
        $function = $this->data['function'] ?? null;

        if (isset($function)) {
            if (!method_exists($this, $function)) {
                echo json_encode(['error' => 'Function not found', 'status' => 404]);
                http_response_code(404);
                return;
            }

            $params = $this->data;
            unset($params['function']);

            call_user_func_array([$this, $function], [$request]);
        } else {
            echo json_encode(['error' => 'Function was not passed', 'status' => 404]);
            http_response_code(404);
        }
    }
}
