<?php

class GetController extends Controller {
    protected function __construct() {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            http_response_code(400);
            return;
        }

        header('Content-Type: application/json');
    }

    
    protected function arguments_exists($arguments) {
        foreach($arguments as $argument) {
            if(!isset($_GET[$argument]))
                return false;
        }

        return true;
    }
}