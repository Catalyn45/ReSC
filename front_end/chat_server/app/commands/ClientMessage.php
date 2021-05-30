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

    public function run($msg, $client, $clients) {
        $this->logger->log_info("am intrat in client message\n");
        if(!isset($msg["message"])) {
            $client->close();
            return;
        }

        $sender = \Client::find($client->id);
        $this->logger->log_info($sender->admin_id);

        foreach ( $clients as $receiver ) {
            echo $receiver->id;
            if($receiver->id == -1)
                continue;

            if($receiver->id == $sender->admin_id) {
                $this->logger->log_info("am gasit adminul\n");
                $admin = \Admin::find($receiver->id);

                if($sender->waiting == true) {
                    $client->socket->close();
                    return;
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

                $receiver->socket->send(json_encode($message));
                $client->socket->send(json_encode(["response_type" =>"success"]));
                return;
            }
        }
    }
}