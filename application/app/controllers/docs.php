<?php

class Docs extends Controller {
    public function index() {
        $this->view('generic_view', [
            'view' => 'docs',
            'css' => [
                'style',
                'docs'
            ],
        ]);
    }
}
