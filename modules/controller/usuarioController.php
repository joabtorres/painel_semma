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

    private function iniciarSessao($usuario)
    {
        $_SESSION['usuario']['id'] = $usuario['id'];
        $_SESSION['usuario']['nome'] = $usuario['nome'];
        $_SESSION['usuario']['anexo'] = $usuario['anexo'];
        $_SESSION['usuario']['status'] = $usuario['status'];
        $url = BASE_URL;
        header("location: $url");
    }

    public function getId()
    {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] > 0) {
            return $_SESSION['usuario']['id'];
        }
    }

    public function getNome()
    {
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['nome'])) {
            return $_SESSION['usuario']['nome'];
        }
    }

    public function getAnexo()
    {
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['anexo'])) {
            return $_SESSION['usuario']['anexo'];
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

    public function editar()
    {
        $arrayCad = $this->validarForm();
        $usuarioModel = usuarioModel::getInstance();
        $arrayError = array(
            'class' => 'bg-danger',
            'msg' => array()
        );

        if ($usuarioModel->usuario_especifico("SELECT * FROM usuario WHERE email=:email and id!=:id", array('email' => $arrayCad['email'], 'id' => $arrayCad['id']))) {
            unset($arrayCad['email']);
            $arrayError['msg'][] = 'E-mail já cadastrado por outro usuário, informe outro e-mail.';
        }
        if (empty($arrayCad['senha']) && empty($arrayCad['rsenha'])) {
            unset($arrayCad['senha']);
            unset($arrayCad['rsenha']);
        } else {
            if ($arrayCad['senha'] != $arrayCad['rsenha']) {
                unset($arrayCad['senha']);
                unset($arrayCad['rsenha']);
                $arrayError['msg'][] = 'Os campos <b>senha</b> e <b>repetir senha</b> estão inválidos, preencha corretamente.';
            }
        }
        if (empty($arrayError['msg'])) {
            $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'));
            if (isset($arrayCad['anexo']['error'])) {
                $arrayError['msg'][] = $arrayCad['anexo']['error'];
            } else if (empty($arrayCad['anexo'])) {
                $anexoUsuario = $usuarioModel->usuario_especifico('SELECT anexo FROM usuario WHERE id=:id', array('id' => $arrayCad['id']));
                if (!empty($anexoUsuario)) {
                    if (file_exists($anexoUsuario['anexo'])) {
                        unlink($anexoUsuario['anexo']); //arquivo removido 
                    }
                }
            }
        }
        if (isset($arrayError['msg']) && is_array($arrayError['msg']) && !empty($arrayError['msg'])) {
            return array('arrayCad' => $arrayCad, 'arrayError' => $arrayError);
        } else {
            if (!empty($arrayCad['senha'])) {
                $arrayCad['senha'] = password_hash($arrayCad['senha'], PASSWORD_BCRYPT);
            }
            $cadHistorico =  $usuarioModel->update($arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "usuario/editar/" . md5($arrayCad['id']);
                header("Location: " . $url);
            }
            return array();
        }
    }

    public function cadastrar()
    {
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
        } else if (strlen($arrayCad['senha']) < 8) {
            unset($arrayCad['senha']);
            unset($arrayCad['rsenha']);
            $arrayError['msg'][] = 'Os campos <b>senha</b> e <b>repetir senha</b> devem possuir no minimo 8 digitos, preencha corretamente.';
        }
        if (empty($arrayError['msg'])) {
            $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'));
            if (isset($arrayCad['anexo']['error'])) {
                $arrayError['msg'][] = $arrayCad['anexo']['error'];
            }
        }
        if (isset($arrayError['msg']) && is_array($arrayError['msg']) && !empty($arrayError['msg'])) {
            return array('arrayCad' => $arrayCad, 'arrayError' => $arrayError);
        } else {
            $arrayCad['senha'] = password_hash($arrayCad['senha'], PASSWORD_BCRYPT);
            $cadHistorico = $usuarioModel->create($arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "usuario/cadastrar";
                header("Location: " . $url);
            }
            return array();
        }
    }

    private function validarForm()
    {
        $arrayCad = array(
            'id' => filter_input(INPUT_POST, 'nCod', FILTER_SANITIZE_SPECIAL_CHARS),
            'nome' => filter_input(INPUT_POST, 'nNome', FILTER_SANITIZE_SPECIAL_CHARS),
            'nome_completo' => filter_input(INPUT_POST, 'nNomeCompleto', FILTER_SANITIZE_SPECIAL_CHARS),
            'email' => filter_input(INPUT_POST, 'nEmail', FILTER_SANITIZE_EMAIL),
            'senha' => filter_input(INPUT_POST, 'nSenha'),
            'rsenha' => filter_input(INPUT_POST, 'nRSenha'),
            'status' => filter_input(INPUT_POST, 'nStatus', FILTER_SANITIZE_SPECIAL_CHARS)
        );
        return $arrayCad;
    }

    private function salvarArquivo($arquivo, $url_file)
    {
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

    public function consultarForm($page)
    {
        $filtro = filter_input(INPUT_GET, 'nSelectBuscar', FILTER_SANITIZE_SPECIAL_CHARS);
        $campo = filter_input(INPUT_GET, 'nCampo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrayForm = array();
        $crudModel = crudModel::getInstance();
        $sql = "SELECT * FROM usuario WHERE id>0 ";
        //nSelectBuscar
        if ($filtro) {
            switch ($filtro) {
                case 'nome_completo':
                    $sql .= " AND nome_completo LIKE '%$campo%' ";
                    break;
                case 'email':
                    $sql .= " AND email LIKE '%$campo%' ";
                    break;
            }
        }
        //paginacao
        $limite = 50;
        $total_registro = $crudModel->read($sql, $arrayForm);
        $total_registro = empty($total_registro) ? array() : $total_registro;
        $paginas = count($total_registro) / $limite;
        $indice = 0;
        $pagina_atual = (isset($page) && !empty($page)) ? addslashes($page) : 1;
        $indice = ($pagina_atual - 1) * $limite;
        $resultado = array(
            'total_registro' => count($total_registro),
            'paginas' => $paginas,
            'pagina_atual' => $pagina_atual,
            'parametros' => "?nSelectBuscar=$filtro&nCampo=$campo&nBuscarBT=BuscarBT"
        );
        $sql .= "  ORDER BY id ASC LIMIT $indice,$limite ";
        $resultado['resultadoDB'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
    public function consultar($page)
    {
        $crudModel = crudModel::getInstance();
        $arrayForm = array();
        $sql = "SELECT * FROM usuario WHERE id>0 ";
        //paginacao
        $limite = 50;
        $total_registro = $crudModel->read($sql, $arrayForm);
        $total_registro = empty($total_registro) ? array() : $total_registro;
        $paginas = count($total_registro) / $limite;
        $indice = 0;
        $pagina_atual = (isset($page) && !empty($page)) ? addslashes($page) : 1;
        $indice = ($pagina_atual - 1) * $limite;
        $resultado = array(
            'total_registro' => count($total_registro),
            'paginas' => $paginas,
            'pagina_atual' => $pagina_atual,
            'parametros' => null
        );
        $sql .= "  ORDER BY id ASC LIMIT $indice,$limite ";
        $resultado['resultadoDB'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }

    public function excluir($id)
    {
        $userModel = usuarioModel::getInstance();
        $resultado = $userModel->usuario_especifico('SELECT * FROM usuario WHERE md5(id) = :id', array('id' => $id));
        if (is_array($resultado)) {
            if (file_exists($resultado['anexo'])) {
                unlink($resultado['anexo']);
            }
            if ($userModel->remove($resultado['id'])) {
                $url = BASE_URL . "usuario/usuario/1";
                header("Location: " . $url);
            }
        }
    }
}
