<?php

namespace Myapp;
use MyApp\utils\Logger;

abstract class Command {
    protected $logger;
    protected function __construct($file_name="") {
        $this->logger = New Logger($file_name);
    }
    public abstract function run($msg, $client, $clients);
    public abstract function getAuth();
}