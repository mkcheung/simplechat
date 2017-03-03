<?php
use \Entity\User;

class UsersController extends MainController{

	public function index(){

		// if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
		// 	return ;
		// }

		$listOfAllUsers = $this->getUsers('html');
		$allRoles = $this->getRoles();
		if($this->request->getFormat() == 'json'){
			// echo $listOfAllUsers;
			echo $this->getUsers('json');
			return;
		}

		include VIEWS."register.html";
	}

	protected function getUsers($preferredFormat=null){
		$listOfUsers = '';
		$userRecords = $this->em->getRepository("\Entity\User")->findAll();

		return $this->returnAllFormat($userRecords, $preferredFormat);
	}

	protected function getRoles($preferredFormat=null){
		$listOfRoles = '';
		$roleRecords = $this->em->getRepository("\Entity\Role")->findAll();

		return $roleRecords;
	}

	private function returnAllFormat($users, $type = null){
		$formattedUsers = '';

		switch($type){
			case 'html':
					foreach($users as $user){
						$formattedUsers .= '<li id="'.$user->getId().'"><div">'.$user->getUserName().'</div><button>Delete</button></li>';
					}
				break;
			default:
				foreach($users as $user){
					$formattedUsers[] = [
						'id'=>$user->getId(),
						'name'=>$user->getUserName()
					];
				}
				$formattedUsers = json_encode($formattedUsers);
				break;
		}
		return $formattedUsers;
	}

	public function create(){

		if($this->request->getVerb() == 'POST'){
			if(!empty($_POST['username'] && !empty($_POST['password']))){
				$roleReturned = $this->em->getRepository('\Entity\Role')->findBy(['id' => $_POST['role']]);
				$role = array_shift($roleReturned);
				$newUser = new User($_POST['username'],$_POST['password'], $role);
				$this->em->persist($newUser);
				$this->em->flush();

				header('Location: /');
			}
		}
	}
}