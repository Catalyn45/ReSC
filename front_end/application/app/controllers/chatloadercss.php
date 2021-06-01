<?php

class ChatLoaderCss extends Controller {
    public function index() {
        header("Content-Type: text/css");
        $configuration = Configuration::find($_GET["server_id"]);
        
        $host = Host::where("server_id", $configuration->id)->first();
        header("Access-Control-Allow-Origin: {$host}");

        if(is_null($configuration))
            return;
        $this->view("autoload_css", $configuration);
    }
}