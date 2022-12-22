<?php
/**
 * A classe 'router' tem como objetivo fazer o load das rotas, verificando os pametros setados
 * 
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @version 1.0
 * @copyright  (c) 2022, Joab Torres Alencar - Analista de Sistemas 
 * @access public
 * @package models
 * @example classe crud_db
 */
class helper
{
    /**
     * bloqueo de instancia da classe
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function __construct() {
    }
    /**
     * @method router getInstance() - Está função tem como objetivo instancia a classe somente uma vez
     * @access public
     * @return helper $inst - instancia carregada da classe helper
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new router();
        }
        return $inst;
    }
    /**
     * Está função é responsável para converte uma data do padrão 'ano-mes-dia' para 'dia/mes/ano'
     * @param String $date - data solicitada pelo parametro
     * @access public
     * @return $date - data formatada no padrão brasileiro
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function dateView($date) {
        $arrayDate = explode("-", $date);
        if (count($arrayDate) == 3) {
            return $arrayDate[2] . '/' . $arrayDate[1] . '/' . $arrayDate[0];
        } else {
            return false;
        }
    }

    /**
     * Está função é responsável para converte uma data do padrão 'dia/mes/ano' para 'ano-mes-dia'
     * @param String $date - data solicitada pelo parametro
     * @access public
     * @return $date - data formatada no padrão banco MySQL
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function formatDateBD($date) {
        $arrayDate = explode("/", $date);
        if (count($arrayDate) == 3) {
            return $arrayDate[2] . '-' . $arrayDate[1] . '-' . $arrayDate[0];
        } else {
            return false;
        }
    }

    /**
     * Está função é responsável para converte uma data do padrão 'ano-mes-dia hora:minutos:segundos' para 'dia/mes/ano hora:minutos:segundos'
     * @param String $date - data solicitada pelo parametro
     * @access public
     * @return $date - data formatada no padrão brasileiro
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function dateViewComplete($date) {
        $datatime = explode(" ", $date);
        $arrayDate = explode("-", $datatime[0]);
        if (count($arrayDate) == 3) {
            return $arrayDate[2] . '/' . $arrayDate[1] . '/' . $arrayDate[0] . ' ' . $datatime[1];
        } else {
            return false;
        }
    }

    /**
     * Está função é responsável para converte uma data do padrão 'ano-mes-dia hora:minutos:segundos' para 'ano-mes-dia horas:minutos:segundos'
     * @param String $date - data solicitada pelo parametro
     * r
     * @access public
     * @return $date - data formatada no padrão brasileiro
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function dateDBComplet($date) {
        $datatime = explode(" ", $date);
        $arrayDate = explode("/", $datatime[0]);
        if (count($arrayDate) == 3) {
            return $arrayDate[2] . '-' . $arrayDate[1] . '-' . $arrayDate[0] . ' ' . $datatime[1];
        } else {
            return false;
        }
    }


    /**
     * Este método é responsável para criar uma sequencia de caracteres aleatória. 
     * @param int $tamanho - tamanho de caracteres a ser gerado;
     * @access public
     * @method mixed getGenerato()
     * @return string os caracteres gerados
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function getGenerato($tamanho = 8) {
        $car_minusculo = 'q w e r t y u i o p a s d f g h j k l z x c v b n m';
        $car_numero = ' 0 1 2 3 4 5 6 7 8 9';
        $car_maiusculo = " Q W E R T Y U I O P A S D F G H J K L Z X C V B N M";
        $car_especial = " ! @ # $ % & Ç ç";

        $retorno = "";
        $caracteres = $car_minusculo . $car_numero . $car_maiusculo . $car_especial;

        $caracteres = explode(" ", $caracteres);
        for ($i = 1; $i <= $tamanho; $i++) {
            $retorno = $retorno . $caracteres[mt_rand(1, count($caracteres) - 1)];
        }
        return $retorno;
    }
    /**
     * Este método é responsável para gerar data e hora atual do sistema. 
     * @param int $tamanho - tamanho de caracteres a ser gerado;
     * @method  datatimeNow()
     * @access public
     * @return string com a data
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function getdatatimeNow() {
        return date("Y-m-d H:i:00", time());
    }
    /**
     * Este método é responsável para gerar data atual do sistema . 
     * @param int $tamanho - tamanho de caracteres a ser gerado;
     * @method  datatimeNow()
     * @access public
     * @return string com a data
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function getdataNow() {
        return date("Y-m-d", time());
    }
    /**
     * Este método é responsável para converte um número double em moeda brasileira
     * @param double $numero - numero double;
     * @access public
     * @return string valor da moeda
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function dinheiroView($numero) {
        return 'R$ ' . number_format($numero, 2, ',', '.');
    }
    /**
     * Este método é responsável para converte um valor da moeda brasileira em double
     * @param string $numero - valor da moeda;
     * @access private
     * @return double com valor da moeda convertido
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function dinheiroDB($numero) {
        $numero = str_replace(",", ".", str_replace('.', '', $numero));
        $array = explode(" ", $numero);
        if (is_array($array)) {
            return $array[1];
        }
    }
}