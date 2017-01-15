<?php

function _h($value)
{
  echo htmlentities($value);
}

function autoloadController($className) {
    $filename = "../controllers/" . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}


spl_autoload_register("autoloadController");
include "../bootstrap.php";
include "../controllers/mainController.php";
require "../Request.php";
require "../Router.php";
define("VIEWS", "../views/");
session_start();

$request = new Request();
$router = new Router();
$router->process($request);

$controllerName = $router->controllerName;
$methodName = $router->methodName;

$controller = new $controllerName($em);
$controller->setRequest($request);
$controller->$methodName();

