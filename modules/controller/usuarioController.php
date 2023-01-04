<?php
class usuarioController
{
    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new usuarioController();
        }
        return $inst;
    }

    public function logar()
    {
        $arrayCad = array(
            'usuario' => filter_input(INPUT_POST, 'nUsuario', FILTER_VALIDATE_EMAIL),
            'senha' => filter_input(INPUT_POST, 'nSenha')
        );
        if ($arrayCad['usuario'] != false) {
            $usuarioModel = usuarioModel::getInstance();
            $resultado = $usuarioModel->verificarEmail($arrayCad['usuario']);
            if (!empty($resultado)) {
                if (password_verify($arrayCad['senha'], $resultado['senha'])) {
                    $this->IniciarSessao($resultado);
                    $url = BASE_URL;
                    header("location: $url");
                } else {
                    return 'Usuário/Senha Incorreto';
                }
            } else {
                return "Usuário/Senha Incorreto";
            }
        } else {
            return 'E-mail Invalido';
        }
    }
    private function IniciarSessao($usuario)
    {
        $_SESSION['usuario']['id'] = $usuario['id'];
        $_SESSION['usuario']['nome'] = $usuario['nome'];
        $_SESSION['usuario']['status'] = $usuario['status'];
    }
    public function getId()
    {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] > 0) {
            return $_SESSION['usuario']['id'];
        }
    }
    public function getNome()
    {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['nome'] > 0) {
            return $_SESSION['usuario']['nome'];
        }
    }
    public function checkUser()
    {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['status'] > 0) {
            return $_SESSION['usuario']['status'];
        } else {
            $url = BASE_URL . 'login';
            header("location: $url");
        }
    }
    public function sair()
    {
        if (isset($_SESSION['usuario'])) {
            $_SESSION = array();
        }
        $url = BASE_URL . 'login';
        header("location: $url");
    }
}
