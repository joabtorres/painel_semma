<?php
class legislacao
{
    private function __construct()
    {
    }
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new legislacao();
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
                move_uploaded_file($arquivo['tmp_name'], '../semma/' . $url_arquivo);
                if (!empty($url_file)) {
                    if (file_exists($url_file)) {
                        unlink($url_file); //arquivo removido 
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
            return filter_input(INPUT_POST, 'nLinkDiario', FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
}