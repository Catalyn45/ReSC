<?php
namespace MyApp\commands;
use MyApp\Command;
class ClientMessage extends Command {
    public function __construct() {
        parent::__construct("ClientMessage.php");
    }
    public function getAuth() {
        return "USER";
    }

    public function getRequiredParams() {
        return [
            "message"
        ];
    }

    public function run($msg, $client, $clients) {
        $this->logger->log_info("Command called");

        $sender = \Client::find($client->id);

        if(is_null($sender)) {
            $this->logger->log_error("Can't find the client");
            return $client->send_error("Something went wrong");
        }

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;

            if($receiver->id == $sender->admin_id) {
                $this->logger->log_info("Admin found");
                $admin = \Admin::find($receiver->id);

                if($sender->waiting == true) {
                    $this->logger->log_info("Not accepted");
                    return $client->send_error("Need to be accepted to send a message");
                }

                $message = [
                    "response_type" => "message",
                    "client_id" => $sender->id,
                    "message" => $msg["message"],
                    "conversation_id" => $sender->conversation_id
                ];

                $m = \Message::create([
                    "sender" => "client",
                    "conversation_id" => $sender->conversation_id,
                    "message" => $msg["message"]
                ]);

                if(is_null($m)) {
                    $this->logger->log_error("Can't create the message");
                    return $client->send_error("Something went wrong");
                }

                $receiver->send_response($message);
                $client->send_response(["response_type" =>"success"]);
                return;
            }
        }
    }
}