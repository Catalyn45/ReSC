<?php

class Create_Account_Method extends PostMethod {
    public function __construct() {
        parent::__construct();
    }
    private $fields = [
        'token' => [
            'mandatory' => true
        ],
        'server_id' => [
            'mandatory' => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $key = Key::create($params);

        if(is_null($key))
            return $this->send_error("Can't add the key");

        return $this->send_success($response=["token" => $key]);
    }
}