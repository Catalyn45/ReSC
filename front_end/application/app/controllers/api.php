<?php
class Api {
    public function execute($method) {
        $class_name = "{$method}_method";

        require "../app/commands/{$class_name}.php";

        if(!class_exists($class_name))
             return ApiMethod::send_error("Endpoint does not exists: " . $class_name);

        $class = new $class_name;

        if(!is_subclass_of($class, $_SERVER['REQUEST_METHOD'] . 'Method'))
            return ApiMethod::send_error("Don't support " . $_SERVER['REQUEST_METHOD'] . " method");

        if($class->need_auth()) {
            if(!isset($_SESSION['valid']) || !$_SESSION['valid']) {
                return ApiMethod::send_error("Not authenticated");
            }
        }

        $required_params = $class->get_required();

        $request_methods = $class->get_methods();
        if(is_null($request_methods))
            $request_methods = [];
            
        $params_to_pass = [];

        foreach($required_params as $key => $value) {
            if(!isset($request_methods[$key])) {
                if($value['mandatory']) {
                    return ApiMethod::send_error("Invalid parameters");
                }

                if(isset($value['default']))
                    $request_methods[$key] = $value['default'];
            }

            $params_to_pass[$key] = $request_methods[$key];
        }

        $remaining = array_diff_key($request_methods, $params_to_pass);

        if(!empty($remaining)) {
            return ApiMethod::send_error("Invalid parameters");
        }

        call_user_func([$class, "run"], $params_to_pass);
    }

    public function test() {

    }
}