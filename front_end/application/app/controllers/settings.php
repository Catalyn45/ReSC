<?php

class Settings extends Controller {
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
