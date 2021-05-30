<?php

class ChatLoader extends Controller {
    public function index() {
        header("Content-Type: application/javascript");

        $configuration = Configuration::find($_GET["server_id"]);

        if(is_null($configuration))
            return;

        $this->view("autoload", $configuration);
    }
}