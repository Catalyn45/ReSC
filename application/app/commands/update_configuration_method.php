<?php

class Update_Configuration_Method extends PatchMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }
    private $fields = [
        'chatcolor_top' => [
            'mandatory' => false
        ],
        'chatcolor_mid' => [
            'mandatory' => false
        ],
        'chatcolor_input' => [
            'mandatory' => false
        ],
        'chatcolor_button' => [
            'mandatory' => false
        ],
        'chatcolor_client' => [
            'mandatory' => false
        ],
        'chatcolor_stranger' => [
            'mandatory' => false
        ],
        'chatposition_line' => [
            'mandatory' => false
        ],
        'chatposition_column' => [
            'mandatory' => false
        ],
        'class_name' => [
            'mandatory' => false
        ],
        'object_name' => [
            'mandatory' => false
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $config = Configuration::updateConfiguration($_SESSION['server_id'], $params);

        if(is_null($config))
            return $this->send_error("Can't update the configuration");

        $this->send_success("Configuration updated!");
    }
}

