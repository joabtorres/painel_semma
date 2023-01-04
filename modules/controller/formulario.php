<?php

class formulario
{

    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new formulario();
        }
        return $inst;
    }
    public function getCoordenacoes()
    {
        $coordenacao = array(
            array(
                'nome' => 'Assessoria Técnica e de Estudos legislativos',
                'sigla' => 'astec'
            ),
            array(
                'nome' => 'Assessoria de Tecnologia da Informação e de Geotecnologia',
                'sigla' => 'astigeo'
            ),
            array(
                'nome' => 'Coordenadoria de Gestão Administrativa e Financeira',
                'sigla' => 'coaf'
            ),
            array(
                'nome' => 'Coordenadoria de Fiscalização Ambiental',
                'sigla' => 'cofisc'
            ),
            array(
                'nome' => 'Coordenadoria de Licenciamento Ambiental',
                'sigla' => 'cla'
            ),
            array(
                'nome' => 'Coordenadoria de Proteção dos Recursos Naturais e Educação Ambiental',
                'sigla' => 'cprn'
            ),
            array(
                'nome' => 'Conselho Municipal de Meio Ambiente',
                'sigla' => 'cmma'
            ),
        );
        return $coordenacao;
    }
    public function cadastrar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad['error'];
        } else {
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->create("INSERT INTO formularios (coordenacao, tipo, data, descricao, anexo) VALUES (:coordenacao, :tipo, :data, :descricao, :anexo)", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "formulario/cadastrar";
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
            $cadHistorico = $crudModel->update("UPDATE formularios SET coordenacao=:coordenacao, tipo=:tipo, data=:data, descricao=:descricao, anexo=:anexo WHERE cod=:cod", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "formulario/editar/" . md5($arrayCad['cod']);
                header("Location: " . $url);
            }
        }
    }
    private function validarForm()
    {
        $arrayCad = array(
            'coordenacao' => filter_input(INPUT_POST, 'nCoordenacao', FILTER_SANITIZE_SPECIAL_CHARS),
            'tipo' => filter_input(INPUT_POST, 'nTipo', FILTER_SANITIZE_SPECIAL_CHARS),
            'data' => filter_input(INPUT_POST, 'nData', FILTER_SANITIZE_SPECIAL_CHARS),
            'descricao' => filter_input(INPUT_POST, 'nDescricao', FILTER_SANITIZE_SPECIAL_CHARS),
        );
        $arrayCad['anexo'] = $this->salvarArquivo($_FILES['nAnexo'], filter_input(INPUT_POST, 'nLinkAnexo'), $arrayCad['coordenacao']);
        if (isset($arrayCad['anexo']['error'])) {
            $arrayCad['error'] = $arrayCad['anexo']['error'];
        }

        return $arrayCad;
    }
    private function salvarArquivo($arquivo, $url_file, $coordenacao)
    {
        if (!empty($arquivo['tmp_name'])) {
            if ($arquivo['type'] == 'application/pdf' || $arquivo['type'] == 'application/msword' || $arquivo['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                switch ($arquivo['type']) {
                    case 'application/pdf':
                        $nome = md5(rand(0, 9999) . time()) . '.pdf';
                        break;
                    case 'application/msword':
                        $nome = md5(rand(0, 9999) . time()) . '.doc';
                        break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        $nome = md5(rand(0, 9999) . time()) . '.docx';
                        break;
                }
                $url_arquivo = "uploads/formularios/$coordenacao/$nome";
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
                        'msg' => 'Só é permitido carregar arquivos em: PDF, .DOC ou .DOCX.'
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
        $resultado = $crudModel->read_specific("SELECT * FROM formularios WHERE md5(cod)=:cod", array('cod' => $id));
        if (isset($resultado) && !empty($resultado) && is_array($resultado)) {
            if (file_exists('../' . $resultado['anexo'])) {
                unlink('../' . $resultado['anexo']);
            }
            $crudModel->remove("DELETE FROM formularios WHERE cod=:cod", array('cod' => $resultado['cod']));
        }
        $url = BASE_URL . "formulario/1";
        header("Location: " . $url);
    }
    public function consultarForm($page)
    {
        $coordenacao = filter_input(INPUT_GET, 'nCoordenacao', FILTER_SANITIZE_SPECIAL_CHARS);
        $tipo = filter_input(INPUT_GET, 'nTipo', FILTER_SANITIZE_SPECIAL_CHARS);
        $filtro = filter_input(INPUT_GET, 'nSelectBuscar', FILTER_SANITIZE_SPECIAL_CHARS);
        $campo = filter_input(INPUT_GET, 'nCampo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrayForm = array();
        $crudModel = crudModel::getInstance();
        $sql = "SELECT * FROM formularios WHERE cod>0 ";
        if ($coordenacao) {
            $sql .= " AND coordenacao=:coordenacao";
            $arrayForm['coordenacao'] = $coordenacao;
        }
        if ($tipo) {
            $sql .= " AND tipo=:tipo";
            $arrayForm['tipo'] = $tipo;
        }
        //nSelectBuscar
        if ($filtro) {
            switch ($filtro) {
                case 'data':
                    $sql .= " AND data LIKE '%" . $campo . "%' ";
                    break;
                case 'descricao':
                    $sql .= " AND descricao LIKE '%" . $campo . "%' ";
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
            'parametros' => "?nCoordenacao=$coordenacao&nTipo=$tipo&nSelectBuscar=$filtro&nCampo=$campo&nBuscarBT=BuscarBT"
        );
        $sql .= "  ORDER BY cod ASC LIMIT $indice,$limite ";
        $resultado['formularios'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
    public function consultar($page)
    {
        $crudModel = crudModel::getInstance();
        $arrayForm = array();
        $sql = "SELECT * FROM formularios WHERE cod>0 ";
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
        $resultado['formularios'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
}