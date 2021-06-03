<?php

abstract class DeleteMethod extends ApiMethod {
    public function __construct($need_auth=false) {
        parent::__construct($need_auth);
    }

    public function get_methods() {
        return $_DELETE;
    }
}