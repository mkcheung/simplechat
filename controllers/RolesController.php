<?php
use \Entity\Role;

class RolesController extends MainController{

	public function determineAction($verb){
		if(!$this->requireAuthenticated()){
			return ;
		}
	}

  // form for the new Role
  // GET /roles/new
  public function prepare() {
  }

  // form the existing role
  // GET /roles/:ID
  public function show() {
    $params = $this->request->getParameters();
    $roleId = $params['id'];
    echo "show $roleId!";
    exit;
    echo json_encode($role);
  }

  // form the existing role
  // PUT/PATCH /roles/:ID
  public function update() {
    $params = $this->request->getParameters();
    $roleId = $params['id'];
    echo "update $roleId!";
    exit;
    $this->redirect('/roles');
  }

  // form the existing role
  // DELETE /roles/:ID
  public function destroy() {
  }

  // form the existing role
  // GET /roles/:ID/edit
  public function edit() {
    $params = $this->request->getParameters();
    $roleId = $params['id'];
    $role = [ 'id' => $roleId, 'name' => 'some name' ];
    $data = [
      'role' => $role
    ];
    include(VIEWS . 'roles/edit.php');
  }

  // GET /roles?start_with=b
	public function index($verb=null){
    $roles = $this->em->getRepository("\Entity\Role")->findAll();
    switch ($this->request->getFormat()) {
      case 'json':
        echo $this->returnAllFormat($roles);
        break;
      default:
        readfile(VIEWS . 'roles/index.html');
        break;
    }
	}

	public function getRoles(){
		$roleRecords = $this->em->getRepository("\Entity\Role")->findAll();
		echo $this->returnAllFormat($roleRecords);
	}

	private function returnAllFormat($roles, $type = null){
		$formattedRoles = [];
    foreach($roles as $role){
      $formattedRoles[] = [
        'id'=>$role->getId(),
        'type'=>$role->getType()
      ];
    }
    $formattedRoles = json_encode($formattedRoles);
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
