<?php
class ClientMessage implements Command {
    public function getAuth() {
        return "USER";
    }

    public function run($msg, $client, $clients) {
        echo "am intrat in client message\n";
        if(!isset($msg["message"])) {
            $client->close();
            return;
        }

        $sender = Client::find($client->id);
        echo $sender->admin_id;

        foreach ( $clients as $receiver ) {
            echo $receiver->id;
            if($receiver->id == -1)
                continue;

            if($receiver->id == $sender->admin_id) {
                echo "am gasit adminul\n";
                $admin = Admin::find($receiver->id);

                if($sender->waiting == true) {
                    $client->socket->close();
                    return;
                }

                $message = [
                    "reponse_type" => "message",
                    "client_id" => $sender->id,
                    "message" => $msg["message"]
                ];

                $receiver->socket->send(json_encode($message));
                $client->socket->send(json_encode(["response_type" =>"success"]));
                return;
            }
        }
    }
}