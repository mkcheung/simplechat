<?php

class Router
{
  var $controllerName;
  var $methodName;

  public function process($request) {
    $verb = $request->getVerb();
    $urlComponents = $request->getUrlComponents();
    $this->controllerName = ucfirst($urlComponents[0]) . 'Controller';
    if (count($urlComponents) == 1) {
      $this->methodName = 'index';
      if ($verb == 'POST') {
        $this->methodName = 'create';
      }
    } else {
      $this->methodName = $urlComponents[1];
      if ($this->methodName == 'new') {
        $this->methodName = 'prepare';
      }
    }
  }
}
