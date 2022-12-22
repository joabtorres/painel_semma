<?php

router::get('', function ($arg) {
    $user = usuario::getInstance();
    if ($user->checkUser()) {
        $view = template::getInstance();

        $dados = array('nome' => 'Joab Torres Alencar');

        $view->loadTemplate('home', $dados);
    }
});


router::getInstance()->loadRouteFile('login');