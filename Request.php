<?php

class Request{

	protected $verb;
	protected $parameters;
	protected $url_components;

	public function __construct(){
		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->assembleURL();
		$this->parseParameters();
	}

	public function getVerb(){
		return $this->verb;
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
