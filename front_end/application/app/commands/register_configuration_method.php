<?php

class Register_Configuration_Method extends PostMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [
        'chatcolor_top' => [
            'mandatory' => true
        ],
        'chatcolor_mid' => [
            'mandatory' => true
        ],
        'chatcolor_input' => [
            'mandatory' => true
        ],
        'chatcolor_button' => [
            'mandatory' => true
        ],
        'chatcolor_client' => [
            'mandatory' => true
        ],
        'chatcolor_stranger' => [
            'mandatory' => true
        ],
        'chatposition_line' => [
            'mandatory' => true
        ],
        'chatposition_column' => [
            'mandatory' => true
        ],
        'class_name' => [
            'mandatory' => true
        ],
        'object_name' => [
            'mandatory' => true
        ],
        'host' => [
            'mandatory' => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $config = Configuration::create(
            $params
        );

        if(is_null($config)) {
            return $this->send_error("Can't add the configuration");
        }

        $this->send_success("Configuration created successfully");
    }
}

