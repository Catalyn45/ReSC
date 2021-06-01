<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MyApp\utils\Logger;

global $logger;
$logger = new Logger($_SERVER["SCRIPT_FILENAME"]);

function validAuthority($authority, $token, $server_id, $client) {
    global $logger;
    if($authority == 'USER') {
        $token = \Key::getToken($token, $server_id);
        if(is_null($token)) {
            $logger->log_info("Client token not found");
            return false;
        }

        return true;
    }

    if($authority == 'ADMIN') {
        $admin = \Admin::getByToken($token);
        $logger->log_info("admin conectat cu success");
        if(is_null($admin)) {
            $logger->log_info("Admin token not found");
            return false;
        }
        $client->id = $admin->id;
        $client->isAdmin = true;

        $logger->log_info("client connected: {$client->id}");
        return true;
    }

    return false;
}

function admin_disconnect($clients, $admin) {
    foreach($clients as $client) {
        if($client->isAdmin)
            continue;

        $client_db = \Client::find($client->id);

        if(is_null($client_db))
            continue;

        if(!$client_db->waiting && $client_db->admin_id == $admin->id) {
            $client->socket->send(json_encode([
                    "response_type" => "disconnected",
                    "message" => "Admin disconnected"
                ]));

            \Client::destroy($client_db->id);
            $client->socket->close();
        }
    }
}

function client_disconnect($clients, $disconnecting_client) {
    global $logger;
    $client_db = \Client::find($disconnecting_client->id);

    if(is_null($client_db))
        return;

    if(!$client_db->waiting) {
        foreach($clients as $client) {
            if($client->id != $client_db->admin_id)
                continue;
            
            $client->socket->send(json_encode([
                "response_type" => "disconnected",
                "message" => "Client disconnected",
                "conversation_id" => $client_db->conversation_id,
                "client_id" => $client_db->id
            ]));

            break;
        }
    } else {
        $admin = \Admin::getByServerId($client_db->server_id);
        $logger->log_info("am gasit admin sa-i trimit disconnect {$admin->id}");
        if(!is_null($admin)) {
            foreach($clients as $client) {
                if(!$client->isAdmin)
                    continue;

                if($client->id == $admin->id) {
                    $logger->log_info("ii trimit acm la admin");
                    $client->socket->send(json_encode([
                        "response_type" => "client_stop_waiting"
                    ]));
                    break;
                }
            }
        }
    }

    \Client::destroy($client_db->id);
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

class Socket implements MessageComponentInterface {
    private $logger;

    public function __construct()
    {
        global $logger;
        $this->clients = new \SplObjectStorage;
        $this->logger = $logger;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach(new ConnectionInfo($conn));
        $this->logger->log_info("New connection! ({$conn->resourceId})");
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

                $command_text = 'MyApp\\commands\\' . $msg["method"];

                $command = new $command_text;

                if(!$command instanceof Command) {
                    $client->close();
                    return;
                }

                if(!validAuthority($command->getAuth(), $msg["token"], $msg["server_id"], $client_info)) {
                    $client->close();
                    echo "nu e valid auth";
                    return;
                }

                $command->run($msg, $client_info, $this->clients);
                return;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->logger->log_info('disconnect');
        foreach($this->clients as $client) {
            if($conn->resourceId == $client->socket->resourceId) {
                $this->clients->detach($client);

                if($client->isAdmin) {
                    admin_disconnect($this->clients, $client);
                }
                else if($client->id != -1) {
                    client_disconnect($this->clients, $client);
                }
                return;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
