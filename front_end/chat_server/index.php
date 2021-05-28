<?php

require dirname( __FILE__ ) . '/../../vendor/autoload.php';
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Socket;

require '../application/app/database.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Socket()
        )
    ),
    8081
);

$server->run();
