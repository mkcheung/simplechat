<?php

class ChatController extends MainController{

	public function determineAction($verb){
		if(!$this->requireAuthenticated()){
			return ;
		}

		switch($verb){
			case 'GET':
				$methodCall = 'index';
				break;
			default:
		}
		$this->$methodCall();

	}

	/** **/
	public function index(){
		readfile(VIEWS."chat.html");
	}

} // end ChatController