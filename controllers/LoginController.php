<?php

class LoginController extends MainController{

	public function index(){
		readfile(VIEWS."login.html");
	}

	public function create(){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $_POST['username'];
			$results = $this->em->getRepository("\Entity\User")->findBy(['username'=>$username]);

			$user = $results[0];

			$password = password_verify($_POST['password'], $user->getPassword());


			if(!empty($user)){

				$_SESSION['user_id'] = $user->getId();
				header('Location: /');
			}
		}
	}

} // end ChatController