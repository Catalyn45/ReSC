<?php
namespace MyApp\commands;
use MyApp\Command;
class Connect extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
    }
    public function getAuth() {
        return "USER";
    }

    public function run($msg, $client, $clients) {
        $db_client = \Client::create([
            "name" => $msg["name"],
            "server_id" => $msg["server_id"],
            "waiting" => true
        ]);

        if(is_null($db_client)) {
            $client->socket->close();
            return;
        }

        $client->id = $db_client->id;
    }
}