<?php
namespace MyApp\commands;
use MyApp\Command;

class CloseClient extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
    }

    public function getAuth() {
        return "ADMIN";
    }

    public function run($msg, $client, $clients) {
        if(!isset($msg["client_id"])) {
            $client->socket->close();
            return;
        }

        $sender = \Client::find($client->id);

        if(is_null($sender) || $sender->admin_id != $client->id) {
            $client->socket->close();
            return;
        }

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;

            if($receiver->id == $msg["client_id"]) {
                $client->socket->send(json_necode([
                    "response_type" => "success",
                    "message" => "successfull"
                ]));

                $receiver->socket->send(json_encode([
                    "response_type" => "disconnected",
                    "message" => "Admin disconnected"
                ]));

                $receiver->socket->close();
                return;
            }
        }
    }
}