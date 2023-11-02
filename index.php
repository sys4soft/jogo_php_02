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
    case 'end':
        $script = 'end.php';
        break;
    default:
        $script = '404.php';
        break;
}

// view
require "inc/header.php";
require "inc/$script";
require "inc/footer.php";