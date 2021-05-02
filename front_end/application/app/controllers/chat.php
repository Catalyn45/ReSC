<?php

class Chat extends Controller {
    public function index() {
        $this->view('generic_logged_view', [
            'view' => 'chat',
            'css' => [
                'style',
                'chat'
            ]
        ]);
    }
}
