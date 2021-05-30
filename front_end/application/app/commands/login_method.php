<?php

class Login_Method extends PostMethod {
    public function __construct() {
        parent::__construct();
    }
    private $fields = [
        'name' => [
            'mandatory' => true
        ],
        'password' => [
            'mandatory' => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $admin = Admin::get_user($params["name"], $params["password"]);

        if(is_null($admin))
            return $this->send_error("Invalid account");

        $_SESSION['valid'] = true;
        $_SESSION['user'] = $admin->name;
        $_SESSION['server_id'] = $admin->server_id;

        Admin::setToken($admin->name, session_id());
        return $this->send_success("Successfuly logged");
    }
}