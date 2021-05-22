<?php

class PostController extends Controller {
    protected $entityBody;

    protected function __construct() {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(400);
            return;
        }

        header('Content-Type: application/json');
        $this->entityBody = $this->get_body();
    }

    protected static function get_body() {
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function arguments_exists($arguments) {
        foreach($arguments as $argument) {
            if(!isset($this->entityBody[$argument]))
                return false;
        }

        return true;
    }
}