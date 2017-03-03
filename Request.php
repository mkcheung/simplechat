<?php

class Request{

	protected $verb;
	protected $parameters;
	protected $url_components;
	protected $format = '';

	public function __construct(){
		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->parseParameters();
		$this->assembleURL();
	}

	public function getVerb(){
		return $this->verb;
	}

	public function getFormat(){
		return $this->format;
	}

	public function setFormat(){

		preg_match('![.](\w+)!', $this->url_components[0], $m);

		if(count($m) >=2 ){
			$this->format = $m[1];
			$this->url_components[0] = preg_replace('!\.\w+$!', '', $this->url_components[0]);
		}
	}

	public function getParameters(){
		return $this->parameters;
	}

	public function getUrlComponents(){
		return $this->url_components;
	}

	protected function assembleURL(){
    	$uri = $_SERVER['REQUEST_URI'];
		$urlAndQuery = explode('?', $uri);
    	$uri = preg_replace('!^/!', '', $urlAndQuery[0]);
		$this->url_components = explode('/', $uri);
		$this->setFormat();
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
					$this->parameters[$key] = $value;
				}
				break;
			case 'application/x-www-form-urlencoded; charset=UTF-8':
			case 'application/x-www-urlencoded':
				parse_str($requestBody, $bodyParameters);
				foreach($bodyParameters as $key => $value){
					$this->parameters[$key] = $value;
				}
				break;
			default:
				break;
		}
	}
}
