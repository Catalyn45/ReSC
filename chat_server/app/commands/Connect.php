<?php
namespace MyApp\commands;
use MyApp\Command;
class Connect extends Command {
    public function __construct() {
        parent::__construct($_SERVER["SCRIPT_FILENAME"]);
    }

    public function getAuth() {
        return "USER";
    }

    public function getRequiredParams() {
        return [
            "name"
        ];
    }

    public function run($msg, $client, $clients) {
        $db_client = \Client::create([
            "name" => $msg["name"],
            "server_id" => $msg["server_id"],
            "waiting" => true
        ]);

        if(is_null($db_client)) {
            return $client->send_error("Can't connect to the server");
        }

        $admin_db = \Admin::getByServerId($msg["server_id"]);

        if(!is_null($admin_db)) {
            foreach($clients as $admin) {
                if(!$admin->isAdmin)
                    continue;

                if($admin->id == $admin_db->id) {
                    $admin->send_response([
                        "response_type" => "client_start_waiting"
                    ]);
                    break;
                }
            }
        }

        $client->id = $db_client->id;
    }
}