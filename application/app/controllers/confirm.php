<?php

class Confirm extends Controller {
    public function index($admin_id, $token) {
        $token = Confirmation::whereToken($token)->where("admin_id", $admin_id)->first();
        $message = null;
        $color = "red";
        if(is_null($token)) {
            $message = "Invalid token";
        } else {
            $admin = Admin::find($admin_id);

            Confirmation::destroy($token->id);

            $result = send_mail($admin->email, "ReSC chat infos", "<h1>These are the infos for the chat:</h1><ul><li>Server id: {$admin->server_id}</li><li>script: &lt;script src=\"https://{$_SERVER['HTTP_HOST']}/chatloader?server_id={$admin->server_id}\"&gt;&lt;/script&gt;</li></ul>");

            if($result) {
                $message = "SUCCESS, the account is now verified, please check your email for the informations";
                $admin->verified = true;
                $admin->save();
                $color = "green";
            } else {
                $message = "Something went wrong";
                Admin::destroy($admin->id);
            }
        }

        $this->view('generic_view', [
            'view' => 'confirm',
            'css' => [
                'style',
                'confirm'
            ],
            'message' => $message,
            'color' => $color
        ]);
    }
}
