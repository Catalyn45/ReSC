<?php

interface Command {
    public function run($msg, $client, $clients);
    public function getAuth();
}