<?php

class Change_Profile_Picture_Method extends PostMethod {
    public function __construct() {
        parent::__construct($need_auth=true);
    }

    private $fields = [
        "image" => [
            "mandatory" => true
        ]
    ];

    public function get_required() {
        return $this->fields;
    }

    public function run($params) {
        list($type, $data) = explode(';', $params["image"]);
        list(,$data) = explode(',', $data);
        $data = base64_decode($data);
        list(,$type) = explode('/', $type);
        
        file_put_contents('/home/catalin/repos/ReSC/front_end/application/public/resources/profile_pictures/' . $_SESSION["id"] . $_SESSION["user"] . "." . $type, $data);

        $admin = Admin::find($_SESSION["id"]);

        if($admin->photo != "resources/profile_photos/default.png")
            unlink($admin->photo);

        $admin->photo = "/resources/profile_pictures/" . $_SESSION["id"] . $_SESSION["user"] . "." . $type;
        $admin->save();

        $this->send_success("Profile picture changed");
    }
}