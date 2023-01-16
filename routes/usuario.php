<?php

router::get('usuario/cadastrar', function($arg){
    $user = usuarioController::getInstance();
    if($user->checkUser()){
        $template = template::getInstance();
        $dados = array();

        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Cadastro realizado com sucesso.");
        }

        $template->loadTemplate('usuario/cadastrar', $dados);
    }
});

router::post('usuario/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $dados = $user->cadastrar();
        }
        $template->loadTemplate('usuario/cadastrar', $dados);
    }
});