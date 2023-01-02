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



router::get('legislacao', function ($arg) {
    $url = BASE_URL . 'legislacao/1';
    header("Location: $url");
});

router::get('legislacao/{page}', function ($arg) {
    $user = usuario::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array('nome' => $user->getNome());
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");
        $legislacao = legislacao::getInstance();
        if(filter_input(INPUT_GET, 'nBuscarBT')){
            $resultado = $legislacao->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['legislacoes'] = $resultado['legislacoes'];
        }else{
            $legislacao = legislacao::getInstance();
            $resultado = $legislacao->consultar($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['legislacoes'] = $resultado['legislacoes'];
        }
        
        $template->loadTemplate('legislacoes/consultar', $dados);
    }
});