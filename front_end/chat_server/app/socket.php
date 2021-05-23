<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

function validAuthority($authority, $token, $server_id) {
    if($authority == 'USER') {
        $token = \Key::getToken($token, $server_id);
        if(is_null($token))
            return false;

        return true;
    }

    if($authority == 'ADMIN') {
        $token = \Admin::GetByToken($token, $server_id);

        if(is_null($token)) {
            log_info("n-am gasit");
            return false;
        }

        return true;
    }

    return false;
}

class ConnectionInfo {
    public function __construct($socket) {
        $this->socket = $socket;
        $this->isAdmin = false;
        $this->id = -1;
    }

    public $socket;
    public $isAdmin;
    public $id;
}

function log_info($msg) {
    $now = new \DateTime();
    echo '[' . $now->format('Y-m-d H:i:s') . "][INFO]{$msg}\n" ;
}

class Socket implements MessageComponentInterface {

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach(new ConnectionInfo($conn));
        log_info("New connection! ({$conn->resourceId})");
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ( $this->clients as $client_info ) {
            $client = $client_info->socket;

            if ($from->resourceId == $client->resourceId ) {
                $msg = json_decode($msg, true);

                if(!isset($msg["method"])) {
                    $client->close();
                    return;
                }

                if(!isset($msg["token"])) {
                    $client->close();
                    return;
                }

                if(!isset($msg["server_id"])) {
                    $client->close();
                    return;
                }

                $command_text = '\\' . $msg["method"];

                if(!in_array("Command", class_implements($command_text))) {
                    $client->close();
                    return;
                }

                $command = new $command_text;

                if(!validAuthority($command->getAuth(), $msg["token"], $msg["server_id"])) {
                    $client->close();
                    return;
                }

                $command->run($msg, $client_info, $this->clients);
                return;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        log_info('disconnect');
        foreach($this->clients as $client) {
            if($conn->resourceId == $client->socket->resourceId) {
                $this->clients->detach($client);

                if($client->id != -1) {
                    \Client::destroy($client->id);
                }
                return;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
