<?php

abstract class PostMethod extends ApiMethod {
    protected $entityBody;

    protected function __construct() {
        parent::__construct();
        $this->entityBody = $this->get_body();
    }

    protected function arguments_exists($arguments) {
        foreach($arguments as $argument) {
            if(!isset($this->entityBody[$argument]))
                return false;
        }
        return true;
    }

    protected static function get_body() {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function get_methods() {
        return $this->entityBody;
    }
}