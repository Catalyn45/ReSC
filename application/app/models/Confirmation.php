<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Confirmation extends Eloquent {
    protected $table = 'confirms';

    protected $fillable = [
        "token",
        "admin_id"
    ];

    public $timestamps = [];
}