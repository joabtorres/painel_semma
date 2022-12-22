<?php
class usuario{
    private function __construct(){}
    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new usuario();
        }
        return $inst;
    }

    public function checkUser(){
        if(isset($_SESSION['usuario']) && $_SESSION['usuario']['status']>0){
            return $_SESSION['usuario']['status'];
        }else{
            $url = BASE_URL.'login';
            header("location: $url");
        }
    }
    public function logar(){
        if(filter_input(INPUT_POST, 'nUsuario')){
            $usuarioModel = usuarioModel::getInstance();
        }
    }
}