<?php
class AcceptClient implements Command {
    public function getAuth() {
        return "ADMIN";
    }

    public function run($msg, $client, $clients) {
        $admin = Admin::getByToken($msg["token"], $msg["server_id"]);
        $client_db = Client::updateAccept($admin->id, $msg["server_id"]);

        $client->id = $admin->id;
        
        if(is_null($client_db)) {
            $client->socket->close();
            return;
        }

        $message = [
            "name" => $admin->name,
            "message" => "Connected"
        ];

        foreach($clients as $client_to_accept) {
            if($client_to_accept->id == $client_db->id) {
                $client_to_accept->socket->send(json_encode($message));
                break;
            }
        }

        $message = [
            "client_id" => $client_db->id,
        ];

        $client->socket->send(json_encode($message));
    }
}