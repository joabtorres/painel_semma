
<?php
class trController
{
    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new trController();
        }
        return $inst;
    }
    public function cadastrar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad['error'];
        } else {
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->create("INSERT INTO termos_de_referencia (tipo, data, descricao, anexo) VALUES (:tipo, :data, :descricao, :anexo)", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "tr/cadastrar";
                header("Location: " . $url);
            }
        }
    }
    public function editar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad;
        } else {
            $arrayCad['id'] = filter_input(INPUT_POST, 'nCod', FILTER_SANITIZE_SPECIAL_CHARS);
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->update("UPDATE termos_de_referencia SET tipo=:tipo, data=:data, descricao=:descricao, anexo=:anexo WHERE id=:id", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "tr/editar/" . md5($arrayCad['id']);
                header("Location: " . $url);
            }
        }
    }
    public function excluir($id)
    {
        $crudModel = crudModel::getInstance();
        $resultado = $crudModel->read_specific("SELECT * FROM termos_de_referencia WHERE md5(id)=:id", array('id' => $id));
        if (isset($resultado) && !empty($resultado) && is_array($resultado)) {
            if (file_exists('../' . $resultado['anexo'])) {
                unlink('../' . $resultado['anexo']);
            }
            $crudModel->remove("DELETE FROM termos_de_referencia WHERE id=:id", array('id' => $resultado['id']));
        }
        $url = BASE_URL . "tr/1";
        header("Location: " . $url);
    }

    public function consultarForm($page)
    {
        $filtro = filter_input(INPUT_GET, 'nSelectBuscar', FILTER_SANITIZE_SPECIAL_CHARS);
        $campo = filter_input(INPUT_GET, 'nCampo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrayForm = array();
        $crudModel = crudModel::getInstance();
        $sql = "SELECT * FROM termos_de_referencia WHERE id>0 ";
        //nSelectBuscar
        if ($filtro) {
            switch ($filtro) {
                case 'data':
                    $sql .= " AND data LIKE '%$campo%' ";
                    break;
                case 'data':
                    $sql .= " AND data LIKE '%$campo%' ";
                    break;
                case 'descricao':
                    $sql .= " AND descricao LIKE '%$campo%' ";
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
        $sql = "SELECT * FROM termos_de_referencia WHERE id>0 ";
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
    
    private function validarForm()
    {
        $arrayCad = array(
            'tipo' => filter_input(INPUT_POST, 'nTipo', FILTER_SANITIZE_SPECIAL_CHARS),
            'data' => filter_input(INPUT_POST, 'nData', FILTER_SANITIZE_SPECIAL_CHARS),
            'descricao' => filter_input(INPUT_POST, 'nDescricao', FILTER_SANITIZE_SPECIAL_CHARS),
        );
        $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'));
        if (isset($arrayCad['anexo']['error'])) {
            $arrayCad['error'] = $arrayCad['anexo']['error'];
        }

        return $arrayCad;
    }
    private function salvarArquivo($arquivo, $url_file)
    {
        if (!empty($arquivo['tmp_name'])) {
            if ($arquivo['type'] == 'application/pdf') {
                $nome = md5(rand(0, 9999) . time()) . '.pdf';
                $url_arquivo = "uploads/termos_de_referencia/cla/$nome";
                move_uploaded_file($arquivo['tmp_name'], '../' . $url_arquivo);
                if (!empty($url_file)) {
                    if (file_exists('../' . $url_file)) {
                        unlink('../' . $url_file); //arquivo removido 
                    }
                }
                return $url_arquivo;
            } else {
                return array(
                    'error' => array(
                        'class' => 'bg-danger',
                        'msg' => 'Só é permitido carregar arquivos em: PDF'
                    )
                );
            }
        } else {
            return $url_file;
        }
    }

}