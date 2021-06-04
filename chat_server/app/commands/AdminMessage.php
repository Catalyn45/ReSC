<?php
namespace MyApp\commands;
use MyApp\Command;
class AdminMessage extends Command {
    public function __construct() {
        parent::__construct("AdminMessaage.php");
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
                $this->logger->log_info("Client found");
                $admin = \Admin::find($client->id);
                $client_receiver = \Client::find($receiver->id);

                if(is_null($admin)) {
                    $this->logger->log_error("Can't find the admin");
                    return $this->error("Something went wrong");
                }

                if(is_null($client_receiver)) {
                    $this->logger->log_info("Can't find the client");
                    return $this->error("Something went wrong");
                }

                if($client_receiver->waiting == true) {
                    $this->logger->log_info("Client is not waiting");
                    return $client->send_error("Client not accepted");
                }

                if($client_receiver->admin_id != $admin->id) {
                    $this->logger->log_info("Different admin_id");
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

                if(is_null($m)) {
                    $this->logger->log_error("Can't create the message");
                    return $client->send_error("Something went wrong");
                }

                $this->logger->log_info("Message created");

                $receiver->send_response($message);
                $client->send_response(["response_type" => "success"]);
                return;
            }
        }
    }
}