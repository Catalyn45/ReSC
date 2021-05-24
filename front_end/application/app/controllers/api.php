<?php
class Api extends PostController {
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $required_params = [
            "name",
            "password"
        ];

        if(!$this->arguments_exists($required_params)) {
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        $admin = Admin::get_user($this->entityBody["name"], $this->entityBody["password"]);

        if(!is_null($admin)) {
            $_SESSION['valid'] = true;
            $_SESSION['user'] = $admin->name;
            $_SESSION['server_id'] = $admin->server_id;

            Admin::setToken($admin->name, session_id());
            return $this->send_response(Controller::SUCCESS_MESSAGE);
        }

        http_response_code(403);
        $this->send_response(Controller::ERROR_MESSAGE);
    }

    public function logout() {
        $_SESSION['valid'] = false;
        $this->send_response(Controller::SUCCESS_MESSAGE);
    }

    public function create_account() {
        $required_params = [
            "name",
            "password",
            "email"
        ];

        if(!$this->arguments_exists($required_params)) {
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        // temporary unavailable
        /*
        $admin = Admin::create(
            $this->entityBody
        );
        */

        if(is_null($admin)) {
            http_response_code(403);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        echo 'success';
    }

    public function register_configuration() {
        $required_params = [
            "chatcolor_top",
            "chatcolor_mid",
            "chatcolor_input",
            "chatcolor_button",
            "chatcolor_client",
            "chatcolor_stranger",
            "chatposition_line",
            "chatposition_column"
        ];

        if(!$this->arguments_exists($required_params)) {
            $this->send_response($this->entityBody);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        $config = Configuration::create(
            $this->entityBody
        );

        if(is_null($config)) {
            http_response_code(403);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        echo $config;
    }

    public function update_configuration() {
        $config = Configuration::updateConfiguration($_SESSION['server_id'], $this->entityBody);

        if(is_null($config)) {
            http_response_code(403);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        echo $config;
    }

    public function get_configuration() {
        $config = Configuration::find($_SESSION['server_id']);
        if(is_null($config)) {
            http_response_code(403);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }
        echo $config;
    }

    public function add_key() {
        $key = Key::create($this->entityBody);

        if(is_null($key)) {
            http_response_code(403);
            return $this->send_response(Controller::ERROR_MESSAGE);
        }

        echo $key;
    }

    public function test() {
        if(isset($_SESSION['valid']) && $_SESSION['valid']) {
            echo 'bine ai venit ' .  $_SESSION['user'];
            return;
        }

        $this->send_response(Controller::ERROR_MESSAGE);
    }
}