<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MyApp\utils\Logger;
use MyApp\utils\Commons;

global $logger;
$logger = new Logger("Socket.php");

function validAuthority($authority, $token, $server_id, $client) {
    global $logger;
    if($authority == 'USER') {
        $token = \Key::getToken($token, $server_id);
        if(is_null($token)) {
            $logger->log_info("Client token not found");
            return false;
        }
        $logger->log_info("client conectat cu success");
        return true;
    }

    if($authority == 'ADMIN') {
        $admin = \Admin::getByToken($token);

        if(is_null($admin)) {
            $logger->log_info("Admin token not found");
            return false;
        }

        $logger->log_info("admin conectat cu success");

        $client->id = $admin->id;
        $client->isAdmin = true;
        return true;
    }

    return false;
}

function admin_disconnect($clients, $admin) {
    foreach($clients as $client) {
        if($client->isAdmin || $client->id == -1)
            continue;

        $client_db = \Client::find($client->id);

        if(is_null($client_db))
            continue;

        if(!$client_db->waiting && $client_db->admin_id == $admin->id) {
            $client->send_response([
                    "response_type" => "disconnected",
                    "message" => "Admin disconnected"
                ]);

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
            
            $client->send_response([
                "response_type" => "disconnected",
                "message" => "Client disconnected",
                "conversation_id" => $client_db->conversation_id,
                "client_id" => $client_db->id
            ]);

            break;
        }
    } else {
        $admin = \Admin::getByServerId($client_db->server_id);

        if(!is_null($admin)) {
            foreach($clients as $client) {
                if(!$client->isAdmin)
                    continue;

                if($client->id == $admin->id) {
                    $logger->log_info("ii trimit acm la admin");
                    $client->send_response([
                        "response_type" => "client_stop_waiting"
                    ]);
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

    public function send_error($message) {
        $this->socket->send(json_encode([
            "response_type" => "error",
            "message" => $message
        ]));
    }
    
    public function send_response($response) {
        $this->socket->send(json_encode($response));
    }

    public $socket;
    public $isAdmin;
    public $id;
}

class Socket implements MessageComponentInterface {
    private $logger;

    public function __construct(){
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

                if(is_null($msg)) {
                    return $client_info->send_error("Invalid json");
                }

                if(!isset($msg["method"])) {
                    return $client_info->send_error("You need to specify a method");
                }

                if(!isset($msg["token"])) {
                    return $client_info->send_error("You need to specify a token");
                }

                $command_text = 'MyApp\\commands\\' . $msg["method"];

                $command = new $command_text;

                if(!$command instanceof Command) {
                    return $client_info->send_error("The command does not exists");
                }

                if($command->getAuth() == "USER") {
                    if(!isset($msg["server_id"])) {
                        return $client_info->send_error("You need to specify the server_id");
                    }
                }

                $req_params = $command->getRequiredParams();

                foreach($req_params as $param) {
                    if(!array_key_exists($param, $msg))
                        return $client_info->send_error("required field does not exists");
                }

                $server_id = null;

                if(isset($msg["server_id"])) {
                    $server_id = $msg["server_id"];
                }

                if(!validAuthority($command->getAuth(), $msg["token"], $server_id, $client_info)) {
                    return $client_info->send_error("don't have the right to use the command");
                }

                $command->run($msg, $client_info, $this->clients);
                return;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach($this->clients as $client) {
            if($conn->resourceId == $client->socket->resourceId) {
                $this->clients->detach($client);

                if($client->isAdmin) {
                    $this->logger->log_info('admin disconnected');
                    admin_disconnect($this->clients, $client);
                }
                else if($client->id != -1) {
                    $this->logger->log_info('client disconnected');
                    client_disconnect($this->clients, $client);
                }
                return;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $this->logger->log_error($e->getMessage());
    }
}
