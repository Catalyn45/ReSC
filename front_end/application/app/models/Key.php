<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Key extends Eloquent {
    protected $table = 'keys';

    protected $fillable = [
        "token",
        "server_id"
    ];

    public $timestamps = [];

    public static function getToken($token, $server_id) {
        $key = Key::whereToken($token)->where('server_id', $server_id)->first();
        return $key;
    }
}