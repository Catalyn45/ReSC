<?php

class Login extends Controller {
    public function index() {
        $this->view('generic_view', [
            'view' => 'login',
            'css' => [
                'style',
                'form',
                'login'
            ],
            'scripts' => [
                'login'
            ]
        ]);
    }
}
