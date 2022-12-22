<?php
/*
 * Environment - define o ambiente que desejo acessa
 * 	development - desenvolvimento
 * 	prodution - repositório web
 */
define("ENVIRONMENT", "development");

//nome do projeto
define("NAME_PROJECT", "Painel Adminstrativo da SEMMA Castanhal");

$config = array();
//Raiz
define("BASE_URL", "http://localhost/painel_semma/");
if (ENVIRONMENT == 'development') {
    //Nome do banco
    $config['db']['dbname'] = 'semma';
    //host
    $config['db']['host'] = 'localhost';
    //usuario
    $config['db']['user'] = 'root';
    //senha
    $config['db']['pass'] = '';
} else {
    //Nome do banco
    $config['db']['dbname'] = 'nome_do_banco';
    //host
    $config['db']['host'] = 'localhost';
    //usuario
    $config['db']['user'] = 'root';
    //senha
    $config['db']['pass'] = '';
};