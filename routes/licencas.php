<?php

router::get('licenca/cadastrar', function ($arg) {
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
router::get('licenca/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['arrayCad'] = $crud->read_specific('SELECT * FROM licencas_emitidas WHERE md5(cod)=:cod', array('cod' => $arg['id']));

        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Alteração realizada com sucesso.");
        }

        $template->loadTemplate('licenca/editar', $dados);
    }
});

router::post('licenca/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $legislcao = licencaController::getInstance();
            $dados['error'] = $legislcao->editar();
        }
        $template->loadTemplate('licenca/editar', $dados);
    }
});

router::get('licenca/excluir/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $licenca = licencaController::getInstance();
        $licenca->excluir($arg['id']);
    }
});

router::get('licenca', function ($arg) {
    $url = BASE_URL . 'licenca/1';
    header("Location: $url");
});

router::get('licenca/{page}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array();
        $licenca = licencaController::getInstance();
        $crud = crudModel::getInstance();
        $dados['ano'] = $crud->read("SELECT DISTINCT(ano) FROM licencas_emitidas");
        if (filter_input(INPUT_GET, 'nBuscarBT')) {
            $resultado = $licenca->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['licencas'] = $resultado['licencas'];
        } else {
            $licenca = licencaController::getInstance();
            $resultado = $licenca->consultar($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['licencas'] = $resultado['licencas'];
        }

        $template->loadTemplate('licenca/consultar', $dados);
    }
});