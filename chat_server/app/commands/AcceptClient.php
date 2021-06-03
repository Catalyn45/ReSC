<?php
namespace MyApp\commands;
use MyApp\Command;

class AcceptClient extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
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
            return $client->send_response($message);
        }

        $conversation = \Conversation::create([
            "admin_id" => $admin->id,
            "client_name" => $client_db->name
        ]);

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
                break;
            }
        }

        $message = [
            "response_type" => "got_client",
            "client_id" => $client_db->id,
            "client_name" =>$client_db->name,
            "conversation_id" =>$conversation->id
        ];

        $client->send_response($message);
    }
}
