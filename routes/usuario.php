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
