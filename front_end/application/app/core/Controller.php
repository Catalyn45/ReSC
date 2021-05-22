<?php

class Controller {
    const ERROR_MESSAGE = [
        "error_type" => "ERROR",
        "message" => "Something went wrong!"
    ];

    const SUCCESS_MESSAGE = [
        "message" => "SUCCESS"
    ];

    protected $need_auth = false;

    protected function view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }

    protected function send_response($response) {
        echo json_encode($response);
    }

    public function need_auth() {
        return $this->need_auth;
    }
}
