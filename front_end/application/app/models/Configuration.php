<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Configuration extends Eloquent {
    protected $table = 'configurations';

    protected $fillable = [
        "chatcolor_top",
        "chatcolor_mid",
        "chatcolor_input",
        "chatcolor_button",
        "chatcolor_client",
        "chatcolor_stranger",
        "chatposition_line",
        "chatposition_column",
        "callback_close",
        "callback_hide",
        "class_name",
        "object_name"
    ];

    public $timestamps = [];


    public static function updateConfiguration($server_id, $new_values) {
        return Configuration::whereId($server_id)->update($new_values);
    }
}