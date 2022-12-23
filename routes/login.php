<?php
router::get('sair', function ($ags) {
    usuario::getInstance()->sair();
});
router::get('login', function ($ags) {
    $view = template::getInstance();
    $dados = array();
    $view->loadView('login', $dados);
});

router::post('login', function ($ags) {
    $view = template::getInstance();
    $dados = array();

    if (isset($_POST['nLogar'])) {
        $user = usuario::getInstance();
        $dados['error'] = $user->logar();
    }

    $view->loadView('login', $dados);
    //gera nova senha
    if (isset($_POST['nNovaSenha'])) {
        if (filter_input(INPUT_POST, 'nEmail', FILTER_VALIDATE_EMAIL)) {
            echo '<script> var myModal = new bootstrap.Modal(document.getElementById("modalEmailSuccess")); </script>';
        } else {
            echo '<script>var myModal = new bootstrap.Modal(document.getElementById("modalEmailError"));myModal.show();</script>';
        }
    }

});