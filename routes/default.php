<?php

router::get('', function ($arg) {
    $user = usuario::getInstance();
    if ($user->checkUser()) {
        $view = template::getInstance();
        $crud = crudModel::getInstance();
        $dados = array('nome' => $user->getNome());
        $dados['legislacoes'] = $crud->read_specific('SELECT COUNT(cod) AS qtd FROM legislacoes');
        $dados['formularios'] = $crud->read_specific('SELECT COUNT(cod) AS qtd FROM formularios');
        $dados['licencas'] = $crud->read_specific('SELECT COUNT(cod) AS qtd FROM licencas_emitidas');
        $dados['trs'] = $crud->read_specific('SELECT COUNT(id) AS qtd FROM termos_de_referencia');

        $view->loadTemplate('home', $dados);
    }
});

router::getInstance()->loadRouteFile('grafico');
router::getInstance()->loadRouteFile('login');