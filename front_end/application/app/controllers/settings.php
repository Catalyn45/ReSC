<?php

class Settings extends Controller {
    public function __construct() {
        $this->need_auth = true;
    }

    public function index() {
        $this->view('generic_logged_view', [
            'view' => 'settings',
            'css' => [
                'style',
                'settings'
            ],
            'scripts' => [
                'settings'
            ]
        ]);
    }
}
