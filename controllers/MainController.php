<?php
use \Doctrine\ORM\EntityManager;


class MainController {
    /** @var EntityManager $em */
	protected $em;

	public function __construct (EntityManager $em){
		$this->em = $em;
	}

	protected function redirect($route=null){
		header('Location: '.$route);
	}

	protected function currentUser(){
		$user = null;

		if(isset($_SESSION['user_id'])){
			$user = $this->em->find('\Entity\User', $_SESSION['user_id']);
		}
		return $user;
	}

	protected function requireAuthenticated(){
		if(!$this->currentUser()){
			$this->redirect('/login');
			return false;
		}
		return true;
	}

	protected function determineAction($verb){
		return;
	}


}