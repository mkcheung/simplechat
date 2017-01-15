<?php

class Request{

	protected $verb;
	protected $parameters;
	protected $format;
	protected $url_components;

	public function __construct(){
		$this->format = 'html';
		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->assembleURL();
		$this->parseParameters();
		if (($this->verb == 'POST') && isset($_POST['_method'])) {
			$this->verb = strtoupper($_POST['_method']);
		}
	}

	public function getVerb(){
		return $this->verb;
	}

	public function getFormat(){
		return $this->format;
	}

	public function setParam($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function getParameters(){
		return $this->parameters;
	}

	public function getUrlComponents(){
		return $this->url_components;
	}

	protected function assembleURL(){
		// $this->parameters = explode('/', $_SERVER['PATH_INFO']);
		$uri = $_SERVER['REQUEST_URI'];
		if (preg_match('!\.(\w+)$!', $uri, $m)) {
			$this->format = $m[1];
			$uri = preg_replace('!\.\w+$!', '', $uri);
		}

		// /messages.json
		// /messages/100.json
		// /messages/100

		$uri = preg_replace('!^/!', '', $uri);
		$this->url_components = explode('/', $uri);
	}

	protected function parseParameters(){
		$content_type = false ;

		if(isset($_SERVER['QUERY_STRING'])){
			parse_str($_SERVER['QUERY_STRING'], $this->parameters);
		}

		$requestBody = file_get_contents('php://input');
		if(isset($_SERVER['CONTENT_TYPE'])){
			$content_type = $_SERVER['CONTENT_TYPE'];
		}

		switch($content_type){
			case 'application/json':
				$bodyParameters = json_decode($requestBody);
				foreach($bodyParameters as $key => $value){
					$parameters[$key] = $value;
				}
				break;
			case 'application/x-www-urlencoded':
				parse_str($requestBody, $bodyParameters);
				foreach($bodyParameters as $key => $value){
					$parameters[$key] = $value;
				}
				break;
			default:
				break;
		}
	}
}
