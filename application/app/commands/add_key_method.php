<?php

class Add_Key_Method extends PostMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }
    private $fields = [
        'token' => [
            'mandatory' => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $key = Key::create([
            "token" => $params['token'], 
            "server_id" => $_SESSION['server_id']
        ]);

        if(is_null($key))
            return $this->send_error("Can't add the key");

        return $this->send_success($response=["token" => $key]);
    }
}