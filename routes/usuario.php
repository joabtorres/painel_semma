<?php

router::get('usuario/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();

        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $arrayError = array(
                'class' => 'bg-success',
                'msg' => array('Cadastro realizado com sucesso')
            );
            $dados['arrayError'] = $arrayError;
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
            $dados = !empty($user->cadastrar()) ? $user->cadastrar() : '';
        }
        $template->loadTemplate('usuario/cadastrar', $dados);
    }
});

router::get('usuario/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['arrayCad'] = $crud->read_specific('SELECT * FROM usuario WHERE md5(id)=:id', array('id' => $arg['id']));
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $arrayError = array(
                'class' => 'bg-success',
                'msg' => array('Alteração realizada com sucesso')
            );
            $dados['arrayError'] = $arrayError;
        }

        $template->loadTemplate('usuario/editar', $dados);
    }
});

router::post('usuario/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $dados = !empty($user->editar()) ? $user->editar() : '';
        }
        $template->loadTemplate('usuario/editar', $dados);
    }
});


router::get('usuario', function ($arg) {
    $url = BASE_URL . 'usuario/1';
    header("location: $url");
});

router::get('usuario/{page}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $controller = usuarioController::getInstance();
        if (filter_input(INPUT_GET, 'nBuscarBT')) {
            $resultado = $controller->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['resultadoDB'] = $resultado['resultadoDB'];
        } else {
            $controller = usuarioController::getInstance();
            $resultado = $controller->consultar($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['resultadoDB'] = $resultado['resultadoDB'];
        }

        $template->loadTemplate('usuario/consultar', $dados);
    }
});

router::get('usuario/excluir/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $user->excluir($arg['id']);
    }
});
