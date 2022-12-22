<?php
/**
 * A classe 'template' é responsável por fazer o carregamento das views
 * 
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @version 1.0
 * @copyright  (c) 2022, Joab Torres Alencar - Analista de Sistemas 
 * @access public
 * @package core
 * @example classe template
 */
class template
{
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
     * @return template $inst - instancia carregada da classe template
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new template();
        }
        return $inst;
    }
    /**
     * Está função é responsável para carrega uma view;
     * @param String viewName - nome da view;
     * @param array $viewData - Dados para serem carregados na view
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function loadView($viewName, $viewData = array()) {
        if (file_exists('templates/' . $viewName . '.php')) {
            extract($viewData);
            include 'templates/' . $viewName . ".php";
        }
    }

    /**
     * Está função é responsável para carrega um template estático, a onde ela chama chama uma função lo;
     * @param String viewName - nome da view;
     * @param array $viewData - Dados para serem carregados na view
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function loadTemplate($viewName, $viewData = array()) {
        include 'templates/template.php';
    }

    /**
     * Está função é responsável para carrega uma view dinamica dentro de um template estático
     * @param String viewName - nome da view;
     * @param array $viewData - Dados para serem carregados na view
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function loadViewInTemplate($viewName, $viewData = array()) {
        if (file_exists('templates/' . $viewName . '.php')) {
            extract($viewData);
            include 'templates/' . $viewName . ".php";
        }
    }
}