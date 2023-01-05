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
                'licenca' => 'DISPENSA DE LICENCIAMENTO AMBIENTAL '
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL DECLARATÓRIA'
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL RURAL'
            ),
            array(
                'licenca' => 'LICENÇA AMBIENTAL SIMPLIFICADA '
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
}
