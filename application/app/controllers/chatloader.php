<?php

class ChatLoader extends Controller {
    public function index() {

        header("Content-Type: application/javascript");

        $configuration = Configuration::find($_GET["server_id"]);
            
        $host = Host::where("server_id", $configuration->id)->first();
        //header("Access-Control-Allow-Origin: {$host}");

        if(is_null($configuration))
            return;

        $this->view("autoload", $configuration);
    }
}