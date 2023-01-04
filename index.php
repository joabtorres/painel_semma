<?php
session_start();
require 'config.php';

spl_autoload_register(function ($class) {
    if (file_exists('modules/' . $class . '/' . $class . '.php')) {
        require 'modules/' . $class . '/' . $class . '.php';
    } elseif (file_exists('modules/database/' . $class . '.php')) {
        require 'modules/database/' . $class . '.php';
    }elseif (file_exists('modules/controller/' . $class . '.php')) {
        require 'modules/controller/' . $class . '.php';
    }
});

core::getInstance()->run($config);