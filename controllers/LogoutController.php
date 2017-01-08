<?php

class LogoutController extends MainController{

	public function determineAction($verb){
		switch($verb){
			case 'GET':
			case 'POST':
				$methodCall = 'logout';
				break;
			default:
		}
		$this->$methodCall($verb);

	}

	public function logout($verb=null){
		unset($_SESSION['user_id']);
		session_destroy();
		header('Location: /');
	}


} // end ChatController