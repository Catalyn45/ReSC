<?php

class App {
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if(isset($url[0])) {
            $controller_file = '../app/controllers/' . $url[0] . '.php';
            if(file_exists($controller_file)) {
                $this->controller = $url[0];
            }
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;


        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
            }
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
