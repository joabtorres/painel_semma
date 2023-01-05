<?php
class licencaController
{
    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new licencaController();
        }
        return $inst;
    }
    public function getLicencas()
    {
        $licenca = array(
            array(
                'licenca' => 'AUTORIZAÇÃO DE FUNCIONAMENTO / EVENTO TEMPORÁRIO'
            ),
            array(
                'licenca' => 'DISPENSA DE LICENCIAMENTO AMBIENTAL'
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL DECLARATÓRIA'
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL RURAL'
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL SIMPLIFICADA'
            ),
            array(
                'licenca' => 'LICENÇA DE ATIVIDADE RURAL'
            ),
            array(
                'licenca' => 'LICENÇA DE INSTALAÇÃO'
            ),
            array(
                'licenca' => 'LICENÇA DE OPERAÇÃO'
            ),
            array(
                'licenca' => 'LICENÇA PRÉVIA'
            )
        );
        return $licenca;
    }
    public function cadastrar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad['error'];
        } else {
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->create("INSERT INTO licencas_emitidas (licenca, ano, n_licenca, n_protocolo, data_emissao, data_validade, empreendimento, tipologia, observacao) VALUES (:licenca, :ano, :n_licenca, :n_protocolo, :data_emissao, :data_validade, :empreendimento, :tipologia, :observacao)", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "licenca/cadastrar";
                header("Location: " . $url);
            }
        }
    }

    private function validarForm()
    {
        $arrayCad = array(
            'licenca' => filter_input(INPUT_POST, 'nLicenca', FILTER_SANITIZE_SPECIAL_CHARS),
            'ano' => filter_input(INPUT_POST, 'nAno', FILTER_SANITIZE_SPECIAL_CHARS),
            'n_licenca' => filter_input(INPUT_POST, 'nNumeroLicenca', FILTER_SANITIZE_SPECIAL_CHARS),
            'n_protocolo' => filter_input(INPUT_POST, 'nNumeroProtocolo', FILTER_SANITIZE_SPECIAL_CHARS),
            'data_emissao' => filter_input(INPUT_POST, 'nDataEmissao', FILTER_SANITIZE_SPECIAL_CHARS),
            'data_validade' => filter_input(INPUT_POST, 'nDataValidade', FILTER_SANITIZE_SPECIAL_CHARS),
            'empreendimento' => filter_input(INPUT_POST, 'nEmpreendimento', FILTER_SANITIZE_SPECIAL_CHARS),
            'tipologia' => filter_input(INPUT_POST, 'nTipologia', FILTER_SANITIZE_SPECIAL_CHARS),
            'observacao' => filter_input(INPUT_POST, 'nDescricao', FILTER_SANITIZE_SPECIAL_CHARS),
        );
        return $arrayCad;
    }
    public function editar()
    {
        $arrayCad = $this->validarForm();
        if (isset($arrayCad['error']) && !empty($arrayCad['error'])) {
            return $arrayCad['error'];
        } else {
            $arrayCad['cod'] = filter_input(INPUT_POST, 'nCod', FILTER_SANITIZE_SPECIAL_CHARS);
            $crudModel = crudModel::getInstance();
            $cadHistorico = $crudModel->update("UPDATE licencas_emitidas SET licenca=:licenca, ano=:ano, n_licenca=:n_licenca, n_protocolo=:n_protocolo, data_emissao=:data_emissao, data_validade=:data_validade, empreendimento=:empreendimento, tipologia=:tipologia, observacao=:observacao WHERE cod=:cod", $arrayCad);
            if ($cadHistorico) {
                $_SESSION['historico_acao'] = true;
                $url = BASE_URL . "licenca/editar/" . md5($arrayCad['cod']);
                header("Location: " . $url);
            }
        }
    }
    public function excluir($id)
    {
        $crudModel = crudModel::getInstance();
        $crudModel->remove("DELETE FROM licencas_emitidas  WHERE md5(cod)=:cod", array('cod' => $id));
        $url = BASE_URL . "licenca/1";
        header("Location: $url");
    }

    public function consultarForm($page)
    {
        $licenca = filter_input(INPUT_GET, 'nLicenca', FILTER_SANITIZE_SPECIAL_CHARS);
        $ano = filter_input(INPUT_GET, 'nAno', FILTER_SANITIZE_SPECIAL_CHARS);
        $filtro = filter_input(INPUT_GET, 'nSelectBuscar', FILTER_SANITIZE_SPECIAL_CHARS);
        $campo = filter_input(INPUT_GET, 'nCampo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrayForm = array();
        $crudModel = crudModel::getInstance();
        $sql = "SELECT * FROM licencas_emitidas WHERE cod>0 ";
        if ($licenca) {
            $sql .= " AND licenca=:licenca";
            $arrayForm['licenca'] = $licenca;
        }
        if ($ano) {
            $sql .= " AND ano=:ano";
            $arrayForm['ano'] = $ano;
        }
        //nSelectBuscar
        if ($filtro) {
            switch ($filtro) {
                case 'n_licenca':
                    $sql .= " AND n_licenca LIKE '%$campo%' ";
                    break;
                case 'n_protocolo':
                    $sql .= " AND n_protocolo LIKE '%$campo%' ";
                    break;
                case 'empreendimento':
                    $sql .= " AND empreendimento LIKE '%$campo%' ";
                    break;
                case 'tipologia':
                    $sql .= " AND tipologia LIKE '%$campo%' ";
                    break;
                case 'observacao':
                    $sql .= " AND observacao LIKE '%$campo%' ";
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
            'parametros' => "?nLicenca=$licenca&nAno=$ano&nSelectBuscar=$filtro&nCampo=$campo&nBuscarBT=BuscarBT"
        );
        $sql .= "  ORDER BY cod ASC LIMIT $indice,$limite ";
        $resultado['licencas'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
    public function consultar($page)
    {
        $crudModel = crudModel::getInstance();
        $arrayForm = array();
        $sql = "SELECT * FROM licencas_emitidas WHERE cod>0 ";
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
        $resultado['licencas'] = $crudModel->read($sql, $arrayForm);
        return $resultado;
    }
}
