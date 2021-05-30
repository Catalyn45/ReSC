<?php

class Create_Account_Method extends PostMethod {
    public function __construct() {
        parent::__construct();
    }
    private $fields = [
        'name' => [
            'mandatory' => true
        ],
        'password' => [
            'mandatory' => true
        ],
        'email' => [
            'mandatory' => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        // temporary unavailable
        /*
        $admin = Admin::create(
            $params
        );
        
        if(is_null($admin)) {
            return $this->send_error("can't create account");
        }
        */

        $this->send_success("Account created successfuly");
    }
}