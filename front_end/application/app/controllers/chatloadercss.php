<?php

class ChatLoaderCss extends Controller {
    public function index() {
        header("Content-Type: text/css");
        $this->view("autoload_css");
    }
}