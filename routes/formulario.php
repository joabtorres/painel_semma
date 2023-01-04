<?php

router::get('formulario/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Cadastro realizado com sucesso.");
        }
        $template->loadTemplate('formulario/cadastrar', $dados);
    }
});

router::post('formulario/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $formulario = formularioController::getInstance();
            $dados['error'] = $formulario->cadastrar();
        }
        $template->loadTemplate('formulario/cadastrar', $dados);
    }
});
router::get('formulario/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['arrayCad'] = $crud->read_specific('SELECT * FROM formularios WHERE md5(cod)=:cod', array('cod' => $arg['id']));
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Alteração realizada com sucesso.");
        }

        $template->loadTemplate('formulario/editar', $dados);
    }
});

router::post('formulario/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $formulario = formularioController::getInstance();
            $dados['error'] = $formulario->editar();
        }
        $template->loadTemplate('formulario/editar', $dados);
    }
});

router::get('formulario/excluir/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $formulario = formularioController::getInstance();
        $formulario->excluir($arg['id']);
    }
});
router::get('formulario', function ($arg) {
    $url = BASE_URL . 'formulario/1';
    header("location: $url");
});
router::get('formulario/{page}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['tipo'] = $crud->read("SELECT DISTINCT(tipo) as tipo FROM formularios");
        $formulario = formularioController::getInstance();
        if (filter_input(INPUT_GET, 'nBuscarBT')) {
            $resultado = $formulario->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['formularios'] = $resultado['formularios'];
        } else {
            $formulario = formularioController::getInstance();
            $resultado = $formulario->consultar($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['formularios'] = $resultado['formularios'];
        }

        $template->loadTemplate('formulario/consultar', $dados);
    }
});