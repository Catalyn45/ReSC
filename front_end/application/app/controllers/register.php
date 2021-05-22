<?php

class Register extends Controller {
    public function index() {
        $this->view('generic_view', [
            'view' => 'register',
            'css' => [
                'style',
                'form',
                'register'
            ],
            'scripts' => [
                'register'
            ]
        ]);
    }
}
