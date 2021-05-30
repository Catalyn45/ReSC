<?php

class Controller {
    protected $need_auth = false;

    protected function view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }

    public function need_auth() {
        return $this->need_auth;
    }
}
