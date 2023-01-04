<?php
router::get('legislacao/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
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
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");
        if (isset($_POST['nSalvar'])) {
            $legislcao = legislacaoController::getInstance();
            $dados['error'] = $legislcao->cadastrar();
        }
        $template->loadTemplate('legislacoes/cadastrar', $dados);
    }
});

router::get('legislacao/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['arrayCad'] = $crud->read_specific('SELECT * FROM legislacoes WHERE md5(cod)=:cod', array('cod' => $arg['id']));
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");

        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Alteração realizada com sucesso.");
        }

        $template->loadTemplate('legislacoes/editar', $dados);
    }
});

router::post('legislacao/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");
        if (isset($_POST['nSalvar'])) {
            $legislcao = legislacaoController::getInstance();
            $dados['error'] = $legislcao->editar();
        }
        $template->loadTemplate('legislacoes/editar', $dados);
    }
});

router::get('legislacao/excluir/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $legislacao = legislacaoController::getInstance();
        $legislacao->excluir($arg['id']);
    }
});

router::get('legislacao', function ($arg) {
    $url = BASE_URL . 'legislacao/1';
    header("Location: $url");
});

router::get('legislacao/{page}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['categoria'] = $crud->read("SELECT DISTINCT(categoria) as categoria FROM legislacoes");
        $dados['esfera'] = $crud->read("SELECT DISTINCT(esfera) as esfera FROM legislacoes");
        $legislacao = legislacaoController::getInstance();
        if(filter_input(INPUT_GET, 'nBuscarBT')){
            $resultado = $legislacao->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['legislacoes'] = $resultado['legislacoes'];
        }else{
            $legislacao = legislacaoController::getInstance();
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