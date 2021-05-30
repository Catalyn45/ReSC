<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Admin extends Eloquent {
    protected $table = 'admins';

    protected $fillable = [
        "name",
        "password",
        "email",
        "server_id"
    ];

    public $timestamps = [];

    public static function get_user($name, $password) {
        return Admin::where(function($query) use ($name){
                                return $query
                                    ->whereName($name)
                                    ->orWhere('email', $name);
                                }
                            )->wherePassword($password)->first();
    }

    public static function setToken($name, $token) {
        return Admin::whereName($name)->update(["token" => $token]);
    }

    public static function getByToken($token) {
        return Admin::whereToken($token)->first();
    }

    public static function getByServerId($server_id) {
        return self::where("server_id", $server_id)->first();
    }
}