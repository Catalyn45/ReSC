<?php
namespace MyApp\commands;
use MyApp\Command;

class CloseClient extends Command {
    public function __construct() {
        parent::__construct("CloseClient.php");
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
        $this->logger->log_info("Command called");
        $sender = \Client::find($msg["client_id"]);

        if(is_null($sender)) {
            $this->logger->log_info("Can't find the client");
            return $client->send_error("Invalid client to close");
        }
        
        
        if($sender->admin_id != $client->id) {
            $this->logger->lof_info("different admin id, can't close");
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