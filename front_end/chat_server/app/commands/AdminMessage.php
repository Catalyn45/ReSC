<?php
class AdminMessage implements Command {
    public function getAuth() {
        return "ADMIN";
    }

    public function run($msg, $client, $clients) {
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
                $admin = Admin::find($client->id);
                $client_receiver = Client::find($receiver->id);

                if($client_receiver->waiting == true) {
                    $client->socket->close();
                    return;
                }

                if($client_receiver->admin_id != $admin->id) {
                    $client->socket->close();
                    return;
                }

                $message = [
                    "message" => $msg["message"]
                ];

                $receiver->socket->send(json_encode($message));
                break;
            }
        }
    }
}