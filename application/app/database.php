<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$url = getenv("DATABASE_URL");
if($url == false) {
    $url = "postgres://postgres:admin@192.168.1.150:5432/Resc";
}

$DATABASE_URL = parse_url($url);

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => $DATABASE_URL["host"],
    'port' => $DATABASE_URL["port"],
    'username' => $DATABASE_URL["user"],
    'password' => $DATABASE_URL["pass"],
    'database' => ltrim($DATABASE_URL["path"], "/"),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->bootEloquent();