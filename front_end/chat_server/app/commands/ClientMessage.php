<?php
class ClientMessage implements Command {
    public function getAuth() {
        return "USER";
    }

    public function run($msg, $client, $clients) {
        if(!isset($msg["message"])) {
            $client->close();
            return;
        }

        $sender = Client::find($client->id);

        foreach ( $clients as $receiver ) {
            if($receiver->id == -1)
                continue;

            if($receiver->id == $sender->admin_id) {
                $admin = Admin::find($receiver->id);

                if($sender->waiting == true) {
                    $client->socket->close();
                    return;
                }

                $message = [
                    "client_id" => $sender->id,
                    "message" => $msg["message"]
                ];

                $receiver->socket->send(json_encode($message));
                $client->socket->send("Success");
                return;
            }
        }
    }
}