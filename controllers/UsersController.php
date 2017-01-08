<?php
use \Entity\User;

class UsersController extends MainController{

	public function determineAction($verb){

		if(!$this->requireAuthenticated()){
			return ;
		}

		switch($verb){
			case 'GET':
				$methodCall = '';
				break;
			case 'POST':
				$methodCall = 'register';
				break;
			default:
		}
		$this->$methodCall($verb);

	}

	public function register($verb=null){
		if($verb == 'POST'){
			if(!empty($_POST['username'] && !empty($_POST['password']))){
				$newUser = new User($_POST['username'],$_POST['password']);
				$this->em->persist($newUser);
				$this->em->flush();

				header('Location: /');
			}
		}
		readfile(VIEWS."register.html");
	}
}