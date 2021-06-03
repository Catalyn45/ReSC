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

        $result = send_mail($admin->email, "ReSC chat infos", "<h1>These are the infos for the chat:</h1><ul><li>Server id: {$admin->server_id}</li><li>script: &lt;script src=\"https://{$_SERVER['HTTP_HOST']}/chatloader?server_id={$admin->server_id}\"&gt;&lt;/script&gt;</li></ul>");
        
        if($result) {
            $this->view("success", "SUCCESS, the account is now verified, please check your email for the informations");
        } else {
            $this->view("success", "Something went wrong");
            Admin::destroy($admin->id);
        }
    }
}
