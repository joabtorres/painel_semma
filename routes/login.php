<?php

router::get('login', function ($ags) {
    $view = template::getInstance();
    $dados = array();

    $view->loadView('login', $dados);
});