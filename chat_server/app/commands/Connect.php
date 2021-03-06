<?php
namespace MyApp\commands;
use MyApp\Command;
class Connect extends Command {
    public function __construct() {
        parent::__construct("Connect.php");
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
        $this->logger->log_info("Command called");
        
        $db_client = \Client::create([
            "name" => $msg["name"],
            "server_id" => $msg["server_id"],
            "waiting" => true
        ]);

        if(is_null($db_client)) {
            $this->logger->log_error("Can't create client");
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

        $client->send_response([
            "response_type" => "success"
        ]);

        $client->id = $db_client->id;
    }
}