<?php

/**
 * A classe 'database' é responsável por efetivar a conexão com o banco de dados
 * 
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @version 1.0
 * @copyright  (c) 2022, Joab Torres Alencar - Analista de Sistemas 
 * @access public
 * @package database
 * @example classe database
 */
class database
{
    /**
     * Instância do objeto da classe PDO()
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private $pdo;

    /**
     * Está função é inicializada ao solicita uma instáncia das classes models, fazendo com que armazene a conexão do banco de dados via classe PDO na variavel $db;
     * @access public
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function __construct() {
        $core = core::getInstance();
        $db = $core->getConfig('db');
        try {
            $this->pdo = new PDO("mysql:dbname=" . $db['dbname'] . ";host=" . $db['host'] . ';charset=utf8', $db['user'], $db['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /**
     * Está função tem como objetivo instancia a classe somente uma vez
     * @access public
     * @return database $inst - retorna a instancia da classe
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new database();
        }
        return $inst;
    }
     /**
     * Está função tem como objetivo retorna a conexão com o banco de dados
     * @access public
     * @return PDO $pdo - retorna a instancia da classe PDO
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    protected function getPDO() {
        return $this->pdo;
    }
}