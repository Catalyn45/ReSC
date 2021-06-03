<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Conversation extends Eloquent {
    protected $table = 'conversations';

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;


    protected $fillable = [
        "admin_id",
        "client_name"
    ];
}