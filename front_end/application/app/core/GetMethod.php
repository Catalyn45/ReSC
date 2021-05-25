<?php

abstract class GetMethod extends ApiMethod {
    public function __construct() {
        parent::__construct();
    }

    public function get_methods() {
        return $_GET;
    }
}