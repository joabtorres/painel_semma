<?php
class legislacaoController
{
    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new legislacaoController();
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
            $cadHistorico = $crudModel->create("INSERT INTO legislacoes(categoria, esfera, numero, ano, data, ementa, diario, anexo) VALUES (:categoria, :esfera, :numero, :ano, :data, :ementa, :diario, :anexo)", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "legislacao/cadastrar";
                header("Location: " . $url);
            }
        }
    }
    public function editar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad['error'];
        } else {
            $arrayCad['cod'] = filter_input(INPUT_POST, 'nCod', FILTER_SANITIZE_SPECIAL_CHARS);
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->update("UPDATE legislacoes SET categoria=:categoria, esfera=:esfera, numero=:numero, ano=:ano, data=:data, ementa=:ementa, diario=:diario, anexo=:anexo WHERE cod=:cod", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "legislacao/editar/" . md5($arrayCad['cod']);
                header("Location: " . $url);
            }
        }
    }

    private function validarForm()
    {
        $arrayCad = array(
            'categoria' => filter_input(INPUT_POST, 'nCategoria', FILTER_SANITIZE_SPECIAL_CHARS),
            'esfera' => filter_input(INPUT_POST, 'nEsfera', FILTER_SANITIZE_SPECIAL_CHARS),
            'numero' => filter_input(INPUT_POST, 'nNumero', FILTER_SANITIZE_SPECIAL_CHARS),
            'ano' => filter_input(INPUT_POST, 'nAno', FILTER_SANITIZE_SPECIAL_CHARS),
            'data' => filter_input(INPUT_POST, 'nData', FILTER_SANITIZE_SPECIAL_CHARS),
            'ementa' => filter_input(INPUT_POST, 'nEmenta', FILTER_SANITIZE_SPECIAL_CHARS),
        );
        $arrayCad['diario'] = $this->salvarArquivo($_FILES['nDiario'], filter_input(INPUT_POST, 'nLinkDiario'));
        $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'));

        if (isset($arrayCad['diario']['error'])) {
            $arrayCad['error'] = $arrayCad['diario']['error'];
        }
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
                $url_arquivo = "uploads/legislacao/$nome";
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
                        'msg' => 'Só é permitido carregar arquivos em PDF.'
                    )
                );
            }

        } else {
            return $url_file;
        }
    }
    public function excluir($id)
    {
        $crudModel = crudModel::getInstance();
        $resultado = $crudModel->read_specific("SELECT * FROM legislacoes WHERE md5(cod)=:cod", array('cod' => $id));
        if (isset($resultado) && !empty($resultado) && is_array($resultado)) {
            if (file_exists('../' . $resultado['diario'])) {
                unlink('../' . $resultado['diario']);
            }
            if (file_exists('../' . $resultado['anexo'])) {
                unlink('../' . $resultado['anexo']);
            }
            $crudModel->remove("DELETE FROM legislacoes WHERE cod=:cod", array('cod' => $resultado['cod']));
        }
        $url = BASE_URL . "legislacao/1";
        header("Location: " . $url);
    }
    public function consultarForm($page)
    {
        $categoria = filter_input(INPUT_GET, 'nCategoria', FILTER_SANITIZE_SPECIAL_CHARS);
        $esfera = filter_input(INPUT_GET, 'nEsfera', FILTER_SANITIZE_SPECIAL_CHARS);
        $filtro = filter_input(INPUT_GET, 'nSelectBuscar', FILTER_SANITIZE_SPECIAL_CHARS);
        $campo = filter_input(INPUT_GET, 'nCampo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrayForm = array();
        $crudModel = crudModel::getInstance();
        $sql = "SELECT * FROM legislacoes WHERE cod>0 ";
        if ($categoria) {
            $sql .= " AND categoria=:categoria";
            $arrayForm['categoria'] = $categoria;
        }
        if ($esfera) {
            $sql .= " AND esfera=:esfera";
            $arrayForm['esfera'] = $esfera;
        }
        //nSelectBuscar
        if ($filtro) {
            switch ($filtro) {
                case 'numero':
                    $sql .= " AND numero LIKE '%" . $campo . "%' ";
                    break;
                case 'ano':
                    $sql .= " AND ano LIKE '%" . $campo . "%' ";
                    break;
                case 'data':
                    $sql .= " AND data LIKE '%" . $campo . "%' ";
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
            'parametros' => "?nCategoria=$categoria&nEsfera=$esfera&nSelectBuscar=$filtro&nCampo=$campo&nBuscarBT=BuscarBT"
        );
        $sql .= "  ORDER BY cod ASC LIMIT $indice,$limite ";
        $resultado['legislacoes'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
    public function consultar($page)
    {
        $crudModel = crudModel::getInstance();
        $arrayForm = array();
        $sql = "SELECT * FROM legislacoes WHERE cod>0 ";
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
        $sql .= "  ORDER BY cod ASC LIMIT $indice,$limite ";
        $resultado['legislacoes'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
}