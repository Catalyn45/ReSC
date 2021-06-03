<?php

abstract class PatchMethod extends PostMethod {
    protected function __construct($need_auth=false) {
        parent::__construct($need_auth);
    }
}