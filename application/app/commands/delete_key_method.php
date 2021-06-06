<?php

class Delete_Key_Method extends DeleteMethod {
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
        $key = Key::whereToken($params['token'])->where('server_id', $_SESSION['server_id']);

        if(is_null($key))
            return $this->send_error("Can't add the key");

        $key->delete();

        return $this->send_success("Key deleted with success");
    }
}