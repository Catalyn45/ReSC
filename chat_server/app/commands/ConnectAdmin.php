<?php
namespace MyApp\commands;
use MyApp\Command;
class ConnectAdmin extends Command {
    public function __construct() {
        parent::__construct("ConnectAdmin.php");
    }

    public function getAuth() {
        return "ADMIN";
    }

    public function getRequiredParams() {
        return [];
    }

    public function run($msg, $client, $clients) {
        $this->logger->log_info("Command called");
        return $client->send_response(["response_type" => "success"]);
    }
}