<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$DATABASE_URL = parse_url(getenv("DATABASE_URL"));

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