<?php

class Get_Messages_Method extends GetMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [
        "conversation_id" => [
            "mandatory" => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }
    
    public function run($params) {
        $admin = Admin::getByToken(session_id());

        $conversation = Conversation::where("admin_id", $admin->id)->whereId($params["conversation_id"])->first();

        if(is_null($conversation)) {
            return $this->send_error("Invalid conversation id");
        }

        $messages = Message::getByConversationId($conversation->id);

        $response = [];
        if(!is_null($messages)) {
            $response = $messages;
        }

        $this->send_success("", $messages);
    }
}