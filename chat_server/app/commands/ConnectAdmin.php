<?php
namespace MyApp\commands;
use MyApp\Command;
class ConnectAdmin extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
    }

    public function getAuth() {
        return "ADMIN";
    }

    public function getRequiredParams() {
        return [];
    }

    public function run($msg, $client, $clients) {
        return $client->send_response(["response_type" => "success"]);
    }
}