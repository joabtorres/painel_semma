<?php
class licencaController
{
    private function __construct()    {
    }
    public static function getInstance(){
        static $inst = null;
        if ($inst === null) {
            $inst = new licencaController();
        }
        return $inst;
    }
    public function getLicencas(){
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
    public function cadastrar()  {
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
        return $arrayCad;
    }
}