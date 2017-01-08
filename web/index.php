<?php

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
define("VIEWS", "../views/");
session_start();


$request = new Request();
$verb = $request->getVerb();
$urlComponents = $request->getUrlComponents();

if(empty($urlComponents[1])){
	$resource = 'chat';
} else {
	$resource = $urlComponents[1];
}

$controller = $resource.'Controller';

$controller = new $controller($em);
$controller->determineAction($verb);
