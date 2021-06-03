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

    public function getRequiredParams() {
        return [
            "client_id"
        ];
    }

    public function run($msg, $client, $clients) {
        $sender = \Client::find($client->id);

        if(is_null($sender) || $sender->admin_id != $client->id) {
            return $client->send_error("Invalid client to close");
        }

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;

            if($receiver->id == $msg["client_id"]) {
                $client->send_response([
                    "response_type" => "success",
                    "message" => "successfull"
                ]);

                $receiver->send_response([
                    "response_type" => "disconnected",
                    "message" => "Admin disconnected"
                ]);

                return $receiver->socket->close();
            }
        }
    }
}