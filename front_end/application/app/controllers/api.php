<?php
class Api {
    public function logout() {
        $_SESSION['valid'] = false;
        $this->send_response(Controller::SUCCESS_MESSAGE);
    }

    public function execute($method) {
        $class_name = "{$method}method";

        require "../app/commands/{$class_name}.php";

        if(!class_exists($class_name))
             return ApiMethod::send_error("Endpoint does not exists: " . $class_name);

        $class = new $class_name;

        if(!is_subclass_of($class, $_SERVER['REQUEST_METHOD'] . 'Method'))
            return ApiMethod::send_error("Don't support " . $_SERVER['REQUEST_METHOD'] . " method");

        $required_params = $class->fields;

        $request_methods = $class->get_methods();

        $params_to_pass = [];

        foreach($required_params as $key => $value) {
            if(!isset($request_methods[$key])) {
                if($value['mandatory']) {
                    return ApiMethod::send_error("Invalid parameters ");
                }

                if(isset($value['default']))
                    $request_methods[$key] = $value['default'];
            }

            $params_to_pass[$key] = $request_methods[$key];
        }

        call_user_func([$class, "run"], $params_to_pass);
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