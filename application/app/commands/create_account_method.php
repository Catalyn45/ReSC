<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Create_Account_Method extends PostMethod {
    public function __construct() {
        parent::__construct();
    }
    private $fields = [
        'name' => [
            'mandatory' => true
        ],
        'password' => [
            'mandatory' => true
        ],
        'email' => [
            'mandatory' => true
        ],
        'host' => [
            'mandatory' => true   
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        if(Admin::userExists($params["name"], $params["email"])) {
            return $this->send_error("Username or email already exists.");
        }

        if(strlen($params["password"]) <= 5) {
            return $this->send_error("The password need to be bigger than 5 characters.");
        }

        $token = md5(uniqid(rand(), true));

        $default_config = Configuration::find(1);

        $new_config = $default_config->replicate();
        $new_config->save();

        Host::create([
            "name" => $params["host"],
            "server_id" => $new_config->id
        ]);

        $admin = Admin::create([
            "name" => $params["name"],
            "password" => $params["password"],
            "email" => $params["email"],
            "verified" => false,
            "server_id" => $new_config->id,
            "photo" => "/resources/profile_pictures/default.png"
        ]);

        $confirm = Confirmation::create([
            "token" => $token,
            "admin_id" => $admin->id
        ]);

        $subject = 'ReSC verifiaction mail';
        $body = "This is the verification mail for your account. Click <a href=\"{$_SERVER['HTTP_HOST']}/confirm/index/{$admin->id}/{$token}\" target=\"_blank\">here</a> to confirm your email address.";

        $result = send_mail($params["email"], $subject, $body);
        if(!$result) {
            Confirmation::destroy($confirm->id);
            Admin::destroy($admin->id);
            return $this->send_error("Can't send the verification mail");
        }

        $new_config->save();
        $admin->save();

        Key::create([
            "token" => "1234",
            "server_id" => $new_config->id
        ]);
        
        $this->send_success("Account created successfuly, check de email for the confirmation link");
    }
}