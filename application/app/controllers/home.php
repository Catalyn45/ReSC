<?php

class Home extends Controller {
    public function index() {
        $this->view('generic_view', [
            'view' => 'index',
            'css' => [
                'style',
                'index'
            ],
            'scripts' => [
                'script'
            ]
        ]);
    }
}
