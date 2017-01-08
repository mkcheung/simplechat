<?php

class LoginController extends MainController{

	public function determineAction($verb){
		switch($verb){
			case 'GET':
			case 'POST':
				$methodCall = 'login';
				break;
			default:
		}
		$this->$methodCall($verb);

	}

	public function login($verb){

		if($verb == 'POST'){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$user = $this->em->getRepository("\Entity\User")->findBy(['username'=>$username, 'password'=>'$2y$10$YxAtgbm7kIhcAQoS1UbIOONn2SX8qTniiLyZYGr9Sz9RoC8jJuZ7m']);
			if(!empty($user)){

				$_SESSION['user_id'] = $user[0]->getId();
				header('Location: /');
			}
		}

		readfile(VIEWS."login.html");
	}

} // end ChatController