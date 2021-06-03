<?php

// This method have no other purpose than testing
class Test_Method extends PostMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $this->send_success('bine ai venit ' .  $_SESSION['user']);
    }
}