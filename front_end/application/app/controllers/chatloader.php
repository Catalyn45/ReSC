<?php

class ChatLoader extends Controller {
    public function index() {
        header("Content-Type: application/javascript");
        $this->view("autoload");
    }
}