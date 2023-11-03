<?php

// start session
session_start();

// define control variable
define('CONTROL', true);

// define routes
$route = $_GET['route'] ?? 'start';

$script = null;
switch($route){
    case 'start':
        $script = 'start.php';
        break;
    case 'game':
        $script = 'game.php';
        break;
    default:
        die('Acesso negado');
        break;
}

// view
require "inc/header.php";
require "inc/$script";
require "inc/footer.php";