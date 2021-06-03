<?php
namespace MyApp\commands;
use MyApp\Command;
class ClientMessage extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
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
        $this->logger->log_info("am intrat in client message\n");

        $sender = \Client::find($client->id);
        $this->logger->log_info($sender->admin_id);

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;

            if($receiver->id == $sender->admin_id) {
                $this->logger->log_info("am gasit adminul\n");
                $admin = \Admin::find($receiver->id);

                if($sender->waiting == true) {
                    return $client->send_error("Need to be accepted to send a message");
                }

                $message = [
                    "response_type" => "message",
                    "client_id" => $sender->id,
                    "message" => $msg["message"],
                    "conversation_id" => $sender->conversation_id
                ];

                \Message::create([
                    "sender" => "client",
                    "conversation_id" => $sender->conversation_id,
                    "message" => $msg["message"]
                ]);

                $receiver->send_response($message);
                $client->send_response(["response_type" =>"success"]);
                return;
            }
        }
    }
}