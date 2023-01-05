<?php
router::get('tr/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $view = template::getInstance();
        $dados = array();
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Cadastro realizado com sucesso.");
        }
        $view->loadTemplate('termo_de_referencia/cadastrar', $dados);
    }
});
router::post('tr/cadastrar', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array('id' => '0');
        if (isset($_POST['nSalvar'])) {
            $controller = trController::getInstance();
            $dados['error'] = $controller->cadastrar();
        }
        $template->loadTemplate('termo_de_referencia/cadastrar', $dados);
    }
});

router::get('tr/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['arrayCad'] = $crud->read_specific('SELECT * FROM termos_de_referencia WHERE md5(id)=:id', array('id' => $arg['id']));
        if (isset($_SESSION['historico_acao']) && !empty($_SESSION['historico_acao'])) {
            $_SESSION['historico_acao'] = false;
            $dados['error'] = array('class' => 'bg-success', 'msg' => "Alteração realizada com sucesso.");
        }
        
        $template->loadTemplate('termo_de_referencia/editar', $dados);
    }
});

router::post('tr/editar/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $template = template::getInstance();
        $dados = array();
        if (isset($_POST['nSalvar'])) {
            $controller = trController::getInstance();
            $resultado = $controller->editar();
            if(isset($resultado['error'])){
                $dados['error'] = $resultado['error'];
                $crud = crudModel::getInstance();
                $dados['arrayCad'] = $crud->read_specific('SELECT * FROM termos_de_referencia WHERE md5(id)=:id', array('id' => $arg['id']));
            }
        }
        $template->loadTemplate('termo_de_referencia/editar', $dados);
    }
});

router::get('tr/excluir/{id}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        $controller = trController::getInstance();
        $controller->excluir($arg['id']);
    }
});

router::get('tr', function ($arg) {
    $url = BASE_URL . 'tr/1';
    header("location: $url");
});
router::get('tr/{page}', function ($arg) {
    $user = usuarioController::getInstance();
    if ($user->checkUser()) {
        // echo $arg['page'];
        $template = template::getInstance();
        $dados = array();
        $crud = crudModel::getInstance();
        $dados['tipo'] = $crud->read("SELECT DISTINCT(tipo) as tipo FROM formularios");
        $controller = trController::getInstance();
        if (filter_input(INPUT_GET, 'nBuscarBT')) {
            $resultado = $controller->consultarForm($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['resultadoDB'] = $resultado['resultadoDB'];
        } else {
            $controller = trController::getInstance();
            $resultado = $controller->consultar($arg['page']);
            $dados['total_registro'] = $resultado['total_registro'];
            $dados['paginas'] = $resultado['paginas'];
            $dados['pagina_atual'] = $resultado['pagina_atual'];
            $dados['parametros'] = $resultado['parametros'];
            $dados['resultadoDB'] = $resultado['resultadoDB'];
        }

        $template->loadTemplate('termo_de_referencia/consultar', $dados);
    }
});
