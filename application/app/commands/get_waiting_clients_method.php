<?php

class Get_Waiting_Clients_Method extends GetMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [];

    public function get_required() {
        return $this->fields;
    }
    
    public function run($params) {
        $nr_clients = Client::getWaitingCount($_SESSION["server_id"]);

        if(is_null($nr_clients))
            $nr_clients = 0;

        $this->send_success("Got waiting clients!", $nr_clients);
    }
}