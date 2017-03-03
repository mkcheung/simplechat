<?php
use \Entity\Role;

class RolesController extends MainController{

	public function index(){

		if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
			return ;
		}

		$listOfAllRoles = $this->getRoles('html');

		if($this->request->getFormat() == 'json'){
			echo $listOfAllRoles;
			return;
		}

		include VIEWS."role.html";
	}

	protected function getRoles($preferredFormat=null){
		$listOfRoles = '';
		$roleRecords = $this->em->getRepository("\Entity\Role")->findAll();

		return $this->returnAllFormat($roleRecords, 'html');
	}

	private function returnAllFormat($roles, $type = null){
		$formattedRoles = '';

		switch($type){
			case 'html':
					foreach($roles as $role){
						$formattedRoles .= '<li id="'.$role->getId().'"><div class="editable">'.$role->getType().'</div> <button>Delete</button></li>';
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

	public function create(){
		if(!empty($_POST['type'])){
			$newRole = new Role($_POST['type']);
			$this->em->persist($newRole);
			$this->em->flush();
		}

		echo $this->returnAllFormat([$newRole]);
	}

	public function update(){

		if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
			return ;
		}

		$parameters = $this->request->getParameters();

		if(!empty($parameters['type']) ){

			$returnedRole = $this->em->getRepository('\Entity\Role')->findBy(['id' => $parameters['id']]);

			$role = $returnedRole[0];
			$role->setType($parameters['type']);
			$this->em->merge($role);
			$this->em->flush();
		}

		// echo $this->returnAllFormat([$role]);
	}

	public function delete(){

		if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
			return ;
		}

		$parameters = $this->request->getParameters();

		if(!empty($parameters['id']) ){

			$returnedRole = $this->em->getRepository('\Entity\Role')->findBy(['id'=> $parameters['id']]);

			$role = $returnedRole[0];

			$this->em->remove($role);
			$this->em->flush();
		}

	}
}