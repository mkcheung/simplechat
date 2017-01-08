<?php
use \Entity\Role;

class RolesController extends MainController{

	public function determineAction($verb){

		if(!$this->requireAuthenticated()){
			return ;
		}

		switch($verb){
			case 'GET':
				$methodCall = 'index';
				break;
			case 'POST':
				$methodCall = 'addRole';
				break;
			default:
		}
		$this->$methodCall($verb);

	}

	public function index($verb=null){
		readfile(VIEWS."role.html");
	}

	public function getRoles(){
		$listOfRoles = '';
		$roleRecords = $this->em->getRepository("\Entity\Role")->findAll();

		echo $this->returnAllFormat($roleRecords);
	}

	private function returnAllFormat($roles, $type = null){
		$formattedRoles = [];

		switch($type){
			case 'html':
					foreach($roles as $role){
						$formattedRoles[] = '<li>'.$role->getType().'</li>';
					}
				break;
			default:
				foreach($roles as $role){
					$formattedRoles[] = [
						'id'=>$role->getId(),
						'type'=>$role->getType()
					];
				}
				$formattedRoles = json_encode($formattedRoles);
				break;
		}
		return $formattedRoles;
	}

	public function addRole($verb=null){
		if($verb == 'POST'){
			if(!empty($_POST['type'])){
				$newRole = new Role($_POST['type']);
				$this->em->persist($newRole);
				$this->em->flush();

			}
			header('Location: /roles');
		}
	}
}