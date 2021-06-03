<?php
session_start();
class App {
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        unset($_GET['url']);
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
            $this->method = $url[1];
            unset($url[1]);
        }
        
        if($this->controller instanceof Api) {
            call_user_func([$this->controller, 'execute'], $this->method);
            return;
        }

        //header("Access-Control-Allow-Origin: localhost");

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
            }
            unset($url[1]);
        }

        if($this->controller->need_auth()) {
            if(!isset($_SESSION['valid']) || !$_SESSION['valid']) {
                header("Location: /login");
                return;
            }
        } else {
            if(isset($_SESSION['valid']) && $_SESSION['valid'] && $this->controller instanceof Login) {
                header("Location: /settings");
                return;
            }
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
