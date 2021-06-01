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

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = 'ancutei.catalin@gmail.com';
        $mail->Password = '<parola_gmail>';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('ancutei.catalin@gmail.com');

        $mail->addAddress($params["email"]);
    
        $mail->isHTML(true);
        $mail->Subject = 'ReSC verifiaction mail';
        $mail->Body = "This is the verification mail for your account. Click <a href=\"localhost/confirm/index/{$admin->id}/{$token}\" target=\"_blank\">here</a> to confirm your email address.";
    
        if(!$mail->send()) {
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
        
        $this->send_success("Account created successfuly");
    }
}