<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Client extends Eloquent {
    protected $table = 'clients';

    protected $fillable = [
        "name",
        "server_id",
        "waiting",
        "admin_id",
        "conversation_id"
    ];

    public $timestamps = [];

    public static function updateAccept($admin_id, $server_id) {
        $client = Client::where('server_id', $server_id)
                        ->whereWaiting(true)->first();

        if(!is_null($client)) {
            $client->update([
                    "admin_id" => $admin_id,
                    "waiting" => false
                ]);
        }
        
        return $client;
    }
}