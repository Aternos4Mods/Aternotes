<?php
namespace App\Http;

class Request
{
    private $data = [];

    public function __construct()
    {
        $this->parseInput();
    }

    private function parseInput()
    {
        if (in_array($_SERVER['CONTENT_TYPE'], ['application/json', 'application/x-www-form-urlencoded'])) {
            $this->data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        } else {
            $this->data = $_POST;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->data = $_GET;
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }
}
