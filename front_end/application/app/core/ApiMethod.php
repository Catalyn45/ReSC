<?php

abstract class ApiMethod {
    protected function __construct() {
        header('Content-Type: application/json');
    }

    public static function send_response($response) {
        echo json_encode($response);
    }

    public static function send_error($message, $args=[]) {
        http_response_code(403);
        ApiMethod::send_response([
            "response" => "ERROR",
            "message" => $message,
            "args" => $args
        ]);
    }

    public static function send_success($message, $args=[]) {
        http_response_code(200);
        ApiMethod::send_response([
            "response" => "SUCCESS",
            "message" => $message,
            "args" => $args
        ]);
    }

    public abstract function run($params);
    public abstract function get_methods();
}