<?php
namespace MyApp\commands;
use MyApp\Command;
class AdminMessage extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
    }

    public function getAuth() {
        return "ADMIN";
    }

    public function run($msg, $client, $clients) {
        $this->logger->log_info("Command called");
        if(!isset($msg["client_id"])) {
            $client->socket->close();
            return;
        }

        if(!isset($msg["message"])) {
            $client->socket->close();
            return;
        }

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;
            
            if($receiver->id == $msg["client_id"]) {
                $this->logger->log_info("Am gasssssit clientul");
                $admin = \Admin::find($client->id);
                $client_receiver = \Client::find($receiver->id);

                if($client_receiver->waiting == true) {
                    $client->socket->close();
                    return;
                }

                $this->logger->log_info("");

                if($client_receiver->admin_id != $admin->id) {
                    $client->socket->close();
                    return;
                }

                $message = [
                    "response_type" => "message",
                    "message" => $msg["message"]
                ];

                $this->logger->log_info("inainte de create " . $client_receiver->conversation_id);

                $m = \Message::create([
                    "sender" => "admin",
                    "conversation_id" => $client_receiver->conversation_id,
                    "message" => $msg["message"]
                ]);

                $this->logger->log_info("dupa de create");

                $receiver->socket->send(json_encode($message));
                $client->socket->send(json_encode(["response_type" => "success"]));
                break;
            }
        }
    }
}