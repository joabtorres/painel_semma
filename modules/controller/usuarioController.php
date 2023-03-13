<?php

class usuarioController {

    private function __construct() {
        
    }

    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new usuarioController();
        }
        return $inst;
    }

    public function logar() {
        $arrayCad = array(
            'usuario' => filter_input(INPUT_POST, 'nUsuario', FILTER_VALIDATE_EMAIL),
            'senha' => filter_input(INPUT_POST, 'nSenha')
        );
        if ($arrayCad['usuario'] != false) {
            $usuarioModel = usuarioModel::getInstance();
            $resultado = $usuarioModel->verificarEmail($arrayCad['usuario']);
            if (!empty($resultado)) {
                if (password_verify($arrayCad['senha'], $resultado['senha'])) {
                    $this->iniciarSessao($resultado);
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

    private function iniciarSessao($usuario) {
        $_SESSION['usuario']['id'] = $usuario['id'];
        $_SESSION['usuario']['nome'] = $usuario['nome'];
        $_SESSION['usuario']['anexo'] = $usuario['anexo'];
        $_SESSION['usuario']['status'] = $usuario['status'];
        $url = BASE_URL;
        header("location: $url");
    }

    public function getId() {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] > 0) {
            return $_SESSION['usuario']['id'];
        }
    }

    public function getNome() {
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['nome'])) {
            return $_SESSION['usuario']['nome'];
        }
    }

    public function getAnexo() {
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['anexo'])) {
            return $_SESSION['usuario']['anexo'];
        }
    }

    public function checkUser() {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['status'] > 0) {
            return $_SESSION['usuario']['status'];
        } else {
            $url = BASE_URL . 'login';
            header("location: $url");
        }
    }

    public function sair() {
        if (isset($_SESSION['usuario'])) {
            $_SESSION = array();
        }
        $url = BASE_URL . 'login';
        header("location: $url");
    }

    public function cadastrar() {
        $arrayCad = $this->validarForm();
        $usuarioModel = usuarioModel::getInstance();
        $arrayError = array(
            'class' => 'bg-danger',
            'msg' => array()
        );
        if ($usuarioModel->verificarEmail($arrayCad['email'])) {
            unset($arrayCad['email']);
            $arrayError['msg'][] = 'E-mail já cadastrado, informe outro email.';
        }
        if ($arrayCad['senha'] != $arrayCad['rsenha']) {
            unset($arrayCad['senha']);
            unset($arrayCad['rsenha']);
            $arrayError['msg'][] = 'Os campos <b>senha</b> e <b>repetir senha</b> estão inválidos, preencha corretamente.';
        }
        if (empty($arrayError['msg'])) {
            $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'));
            if (isset($arrayCad['anexo']['error'])) {
                $arrayError['msg'][] = $arrayCad['anexo']['error'];
            }
        }
        if (isset($arrayError['msg']) && is_array($arrayError['msg']) && !empty($arrayError['msg'])) {
            return $arrayReturn = array('arrayCad' => $arrayCad, 'arrayError' => $arrayError);
        } else {
            $arrayCad['senha'] = password_hash($arrayCad['senha'], PASSWORD_BCRYPT);
            $usuarioModel->create($arrayCad);
        }
    }

    private function validarForm() {
        $arrayCad = array(
            'nome' => filter_input(INPUT_POST, 'nNome', FILTER_SANITIZE_SPECIAL_CHARS),
            'nome_completo' => filter_input(INPUT_POST, 'nNomeCompleto', FILTER_SANITIZE_SPECIAL_CHARS),
            'email' => filter_input(INPUT_POST, 'nEmail', FILTER_SANITIZE_EMAIL),
            'senha' => filter_input(INPUT_POST, 'nSenha'),
            'rsenha' => filter_input(INPUT_POST, 'nRSenha')
        );
        return $arrayCad;
    }

    private function salvarArquivo($arquivo, $url_file) {
        if (!empty($arquivo['tmp_name'])) {
            if ($arquivo['type'] == 'image/png' || $arquivo['type'] == 'image/jpeg') {
                $imagem = array();
                $largura = 140;
                $altura = 140;
                $imagem['temp'] = $arquivo['tmp_name'];
                $imagem['extensao'] = explode(".", $arquivo['name']);
                $imagem['extensao'] = strtolower(end($imagem['extensao']));
                $imagem['name'] = md5(rand(0, 900000) . time()) . '.' . $imagem['extensao'];
                $imagem['diretorio'] = 'assets/uploads/usuarios/';

                list($larguraOriginal, $alturaOriginal) = getimagesize($imagem['temp']);

                $ratio = max($largura / $larguraOriginal, $altura / $alturaOriginal);
                $alturaOriginal = $altura / $ratio;
                $x = ($larguraOriginal - $largura / $ratio) / 2;
                $larguraOriginal = $largura / $ratio;

                $imagem_final = imagecreatetruecolor($largura, $altura);

                if ($imagem['extensao'] == 'jpg' || $imagem['extensao'] == 'jpeg') {
                    $imagem_original = imagecreatefromjpeg($imagem['temp']);
                    imagecopyresampled($imagem_final, $imagem_original, 0, 0, $x, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
                    imagejpeg($imagem_final, $imagem['diretorio'] . $imagem['name'], 90);
                } else if ($imagem['extensao'] == 'png') {
                    $imagem_original = imagecreatefrompng($imagem['temp']);
                    imagecopyresampled($imagem_final, $imagem_original, 0, 0, $x, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
                    imagepng($imagem_final, $imagem['diretorio'] . $imagem['name']);
                }
                $url_arquivo = $imagem['diretorio'] . $imagem['name'];

                if (!empty($url_file)) {
                    if (file_exists($url_file)) {
                        unlink($url_file); //arquivo removido 
                    }
                }
                return $url_arquivo;
            } else {
                return array('error' => 'Só é permitido carregar arquivos em: .JPG, .JPEG ou .PNG.');
            }
        } else {
            return $url_file;
        }
    }

}
