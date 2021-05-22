<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => '192.168.1.150',
    'username' => 'postgres',
    'password' => 'admin',
    'database' => 'Resc',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->bootEloquent();