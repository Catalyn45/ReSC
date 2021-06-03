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

    public function getRequiredParams() {
        return [
            "client_id",
            "message"
        ];
    }

    public function run($msg, $client, $clients) {
        $this->logger->log_info("Command called");

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;
            
            if($receiver->id == $msg["client_id"]) {
                $this->logger->log_info("Am gasit clientul");
                $admin = \Admin::find($client->id);
                $client_receiver = \Client::find($receiver->id);

                if($client_receiver->waiting == true) {
                    return $client->send_error("Client not accepted");
                }

                if($client_receiver->admin_id != $admin->id) {
                    return $client->send_error("Don't have rights to send messages to this client");
                }

                $message = [
                    "response_type" => "message",
                    "message" => $msg["message"]
                ];

                $m = \Message::create([
                    "sender" => "admin",
                    "conversation_id" => $client_receiver->conversation_id,
                    "message" => $msg["message"]
                ]);

                $this->logger->log_info("am creat un admin nou");

                $receiver->send_response($message);
                $client->send_response(["response_type" => "success"]);
                return;
            }
        }
    }
}