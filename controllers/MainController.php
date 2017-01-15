<?php
use \Doctrine\ORM\EntityManager;


class MainController {
    /** @var EntityManager $em */
	protected $em;

	protected $request;

	public function __construct (EntityManager $em){
		$this->em = $em;
	}

  public function setRequest(Request $request)
  {
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

	protected function requireRole($roleName) {
    $user = $this->currentUser();
    //$user->hasRole('')
  }

	protected function determineAction($verb){
		return;
	}


}
