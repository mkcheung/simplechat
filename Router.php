<?php

class Router
{
  var $controllerName;
  var $methodName;

  public function process($request) {
    $verb = $request->getVerb();
    $urlComponents = $request->getUrlComponents();
    $defaultControllerPrefix = 'login';

    if(!empty($_SESSION['user_id'])){
      $defaultControllerPrefix = 'chat';
    }

    $this->controllerName = (empty($urlComponents[0]) ? $defaultControllerPrefix : ucfirst($urlComponents[0])) . 'Controller';
    if (count($urlComponents) == 1) {
      $this->methodName = 'index';
      if ($verb == 'POST') {
        $this->methodName = 'create';
      }
      if ($verb == 'PATCH' || $verb == 'PUT' ) {
        $this->methodName = 'update';
      }
      if ($verb == 'DELETE' ) {
        $this->methodName = 'delete';
      }
    } else {
      $this->methodName = $urlComponents[1];
      if ($this->methodName == 'new') {
        $this->methodName = 'prepare';
      }
    }
  }
}
