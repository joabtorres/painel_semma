<?php 

router::get('licenca/cadastrar', function($arg){
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Cadastro realizado com sucesso.");
        }
        $template->loadTemplate('licenca/cadastrar', $dados);
    }
});

router::post('licenca/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $licenca = licencaController::getInstance();
            $dados['error'] = $licenca->cadastrar();
        }
        $template->loadTemplate('licenca/cadastrar', $dados);
    }
});