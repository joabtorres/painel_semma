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
class router
{
    /**
     * Class $core - reference a instância da classe core;
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private $core;
    /**
     * Array $get - refere-se a solicitação da rota via get
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private $get;
    /**
     * Array $post - refere-se a solicitação da rota via POST
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private $post;
    /**
     * bloqueo de instancia classe
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function __construct() {
    }
    /**
     * @method router getInstance() - Está função tem como objetivo instancia a classe somente uma vez
     * @access public
     * @return router $inst - instancia carregada da classe router
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
     * @method router load() - Está função tem como objetivo solicita a leitura da rota default e retorna a instancia da classe router
     * @access public
     * @return router instancia carregada da classe router
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function load() {
        $this->core = core::getInstance();
        $this->loadRouteFile('default');
        return $this;
    }
    /**
     * @method loadRouteFile() - tem como objetivo incluir e carregar as rotas fora do arquivo default.php
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function loadRouteFile($f) {
        if (file_exists('routes/' . $f . '.php')) {
            require 'routes/' . $f . '.php';
        }
    }
    /**
     * @method match() - tem como objetivo tratar o recebimento das requisições por meio de GET e POST. Além disso, verifica tem rota, se a mesma existe, caso contrario será redirecionado para página 404
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function match () {
        $this->goHTTPS();
        $url = (isset($_GET['url'])) ? $_GET['url'] : '';
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
            default:
                $type = $this->get;
                break;
            case 'POST':
                $type = $this->post;
                break;
        }
        //Loop em todos os routes
        $route_exist = null;
        foreach ($type as $pt => $func) {
            //identifica os argumentos e substitui por regex
            $pattern = preg_replace('(\{[a-z0-9]{0,}\})', '([a-z0-9]{0,})', $pt);
            //faz o match de URL
            if (preg_match('#^(' . $pattern . ')*$#i', $url, $matches) === 1) {
                array_shift($matches);
                array_shift($matches);
                //pega todos os argumentos para associar
                $itens = array();
                if (preg_match_all('(\{[a-z0-9]{0,}\})', $pt, $m)) {
                    $itens = preg_replace('(\{|\})', '', $m[0]);
                }
                //faz a associação
                $arg = array();
                foreach ($matches as $key => $match) {
                    $arg[$itens[$key]] = $match;
                }
                $route_exist = true;
                $func($arg);
                break;
            }
        }
        if ($route_exist == false) {
            $template = template::getInstance();
            $template->loadView('404');
        }
    }
    /**
     * @method get() - Parametro de requisição do route $_GET
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function get($pattern, $function) {
        router::getInstance()->get[$pattern] = $function;
    }
    /**
     * @method post() - Parametro de requisição do route $_POST
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function post($pattern, $function) {
        router::getInstance()->post[$pattern] = $function;
    }

    /**
     * Está função tem como objetivo redirecionar automaticamente o endereço HTTP para o HTTPS.
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function goHTTPS() {

        if (!isset($_SERVER['HTTPS']) && ENVIRONMENT == "prodution") {
            if ($_SERVER['HTTPS'] != "on") {
                header('Location: https://' . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']);
            }
        }
    }
}

?>