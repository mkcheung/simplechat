<?php

class LogoutController extends MainController{

	public function index($verb=null){
		unset($_SESSION['user_id']);
		session_destroy();
		header('Location: /');
	}


} // end ChatController