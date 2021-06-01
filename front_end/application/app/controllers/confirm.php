<?php

class Confirm extends Controller {
    public function index($admin_id, $token) {
        $token = Confirmation::whereToken($token)->where("admin_id", $admin_id)->first();

        if(is_null($token)) {
            return $this->view("success", "Invalid token");
        }

        $admin = Admin::find($admin_id);
        $admin->verified = true;
        $admin->save();

        Confirmation::destroy($token->id);
        
        $this->view("success", "SUCCESS, insert this script into your website: &lt;script src=\"https://localhost/chatloader?server_id={$admin->server_id}\"&gt;&lt;/script&gt");
    }
}
