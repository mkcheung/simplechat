<?php
use \Doctrine\ORM\EntityManager;


class MainController {
    /** @var EntityManager $em */
	protected $em;

    /** @var Request $request */
	protected $request;

	public function __construct (EntityManager $em,Request $request){
		$this->em = $em;
		$this->request = $request;
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

	protected function requireAdminRole(){
		if(!$this->currentUser()->getRole()->getType() == 'Admin'){
			$this->redirect('/login');
			return false;
		}
		return true;
	}

	protected function determineAction($verb){
		return;
	}


}