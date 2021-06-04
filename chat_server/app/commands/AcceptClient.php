<?php
namespace MyApp\commands;
use MyApp\Command;

class AcceptClient extends Command {
    public function __construct() {
        parent::__construct("AcceptClient.php");
    }

    public function getAuth() {
        return "ADMIN";
    }

    public function getRequiredParams() {
        return [];
    }

    public function run($msg, $client, $clients) {
        $this->logger->log_info("Command called");
        $admin = \Admin::getByToken($msg["token"]);

        $client_db = \Client::updateAccept($admin->id, $admin->server_id);

        if(is_null($client_db)) {
            $message = [
                "response_type" => "nothing",
                "message" => "No clients waiting"
            ];
            $this->logger->log_info("No clients are waiting");
            return $client->send_response($message);
        }

        $conversation = \Conversation::create([
            "admin_id" => $admin->id,
            "client_name" => $client_db->name
        ]);

        if(is_null($conversation)) {
            $this->logger->log_error("Can't create a new conversation");
            return $client->send_error("Something went wrong");
        }

        $client_db->update(["conversation_id" =>$conversation->id]);
        $client_db->save();

        $message = [
            "response_type" => "accepted",
            "name" => $admin->name,
            "message" => "Connected",
            "photo" => $admin->photo
        ];

        foreach($clients as $client_to_accept) {
            if($client_to_accept->id == $client_db->id) {
                $client_to_accept->send_response($message);
                $this->logger->log_info("response send to the client");
                break;
            }
        }

        $message = [
            "response_type" => "got_client",
            "client_id" => $client_db->id,
            "client_name" =>$client_db->name,
            "conversation_id" =>$conversation->id
        ];
        
        $this->logger->log_info("response send to the admin");
        $client->send_response($message);
    }
}
