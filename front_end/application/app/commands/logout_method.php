<?php

class Logout_Method extends PostMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }
    private $fields = [];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $_SESSION['valid'] = false;
        $this->send_success("Logout successfully");
    }
}