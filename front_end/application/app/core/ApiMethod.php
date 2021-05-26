<?php

abstract class ApiMethod {
    protected $need_auth;
    protected function __construct($need_auth) {
        header('Content-Type: application/json');
        $this->need_auth = $need_auth;
    }

    public function need_auth() {
        return $this->need_auth;
    }

    public static function send_response($response) {
        echo json_encode($response);
    }

    public static function send_error($message="Successfuly request", $response=[]) {
        http_response_code(403);
        ApiMethod::send_response([
            "response_type" => "ERROR",
            "message" => $message,
            "response" => $response
        ]);
    }

    public static function send_success($message="Some error ocurred", $response=[]) {
        http_response_code(200);
        ApiMethod::send_response([
            "response_type" => "SUCCESS",
            "message" => $message,
            "response" => $response
        ]);
    }

    public abstract function run($params);
    public abstract function get_methods();
    public abstract function get_required();
}