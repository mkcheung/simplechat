<?php

class Router
{
	var $controllerName;
	var $methodName;

	public function process($request) {
		$verb = $request->getVerb();
		$urlComponents = $request->getUrlComponents();
		$this->controllerName = ucfirst($urlComponents[0]) . 'Controller';
		$count = count($urlComponents);
		if ($count == 1) {
			$this->methodName = 'index';
			if ($verb == 'POST') {
				$this->methodName = 'create';
			}
		} else {
			$component1 = $urlComponents[0];
			$component2 = $urlComponents[1];
			$component3 = ($count == 3) ? $urlComponents[2] : '';
			$this->methodName = $component2;
			if ($this->methodName == 'new') {
				$this->methodName = 'prepare';
			} else if (preg_match('!^\d+$!', $this->methodName, $m)) {
				$this->methodName = 'show';
				$request->setParam('id', $m[0]);
				switch ($verb) {
					case 'GET':
						if ($component3 == 'edit') {
							$this->methodName = 'edit';
						}
					break;
					case 'PUT':
					case 'PATCH':
						$this->methodName = 'update';
						break;
					case 'DELETE':
						$this->methodName = 'destroy';
						break;
					}
			}
		}
	}
}
