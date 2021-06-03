<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Message extends Eloquent {
    protected $table = 'messages';

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    protected $fillable = [
        "sender",
        "message",
        "conversation_id"
    ];

    public static function getByConversationId($conversation_id) {
        return self::where("conversation_id", $conversation_id)->orderBy('id', 'ASC')->get()->toArray();
    }
}