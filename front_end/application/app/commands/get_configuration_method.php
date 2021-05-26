<?php

class Get_Configuration_Method extends GetMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        $config = Configuration::find($_SESSION['server_id']);
        if(is_null($config))
            return $this->send_error("Can't get the config");

        $this->send_success($message="Got configuration with succeessw",$response=$config);
    }
}