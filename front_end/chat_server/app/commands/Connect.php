<?php

class Connect implements Command {
    public function getAuth() {
        return "USER";
    }

    public function run($msg, $client, $clients) {
        $db_client = Client::create([
            "name" => $msg["name"],
            "server_id" => $msg["server_id"],
            "waiting" => true
        ]);

        if(is_null($db_client)) {
            $client->socket->close();
            return;
        }

        $client->id = $db_client->id;

        $client->socket->send("success");
    }
}