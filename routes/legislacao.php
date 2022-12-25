<?php
router::get('legislacao/cadastrar', function ($arg) {
    $user = usuario::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array('nome' => $user->getNome());
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");

        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Cadastro realizado com sucesso.");
        }
        
        $template->loadTemplate('legislacoes/cadastrar', $dados);
    }
});

router::post('legislacao/cadastrar', function ($arg) {
    $user = usuario::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array('nome' => $user->getNome());
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");
        if (isset($_POST['nSalvar'])) { 
            $legislcao = legislacao::getInstance();
            $dados['error'] = $legislcao->cadastrar();
        }    


        $template->loadTemplate('legislacoes/cadastrar', $dados);
    }
});