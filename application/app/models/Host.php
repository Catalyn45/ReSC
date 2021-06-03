<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Host extends Eloquent {
    protected $table = 'hosts';

    protected $fillable = [
        "name",
        "server_id"
    ];

    public $timestamps = [];
}