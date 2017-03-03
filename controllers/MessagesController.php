<?php
use \Entity\Message;
use \Entity\User;

class MessagesController extends MainController{

	public function index(){

		if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
			return ;
		}

		$parameters = $this->request->getParameters();
// var_dump(isset($parameters['directedTo']));die;
		$listOfAllMessages = isset($parameters['directedTo']) ? $this->getMessagesDirectedTo($parameters['directedTo']) : $this->getMessages('html') ;

		if($this->request->getFormat() == 'json'){
			echo $listOfAllMessages;
			return;
		}
	}

	public function create(){

		$incomingMessage = $_POST['message'];
		$sendToUser='';
		if(isset($_POST['sendToUser']) && $_POST['sendToUser'] != ''){
			$returnedUsers = $this->em->getRepository('\Entity\User')->findBy(['id' => $_POST['sendToUser']]);
			$sendToUser = array_shift($returnedUsers);
		}
		$message = new Message($incomingMessage, $this->currentUser(), $sendToUser);
		$this->em->persist($message);
		$this->em->flush();

		//echo json_encode(array('id' => $message->id));
 		echo $this->returnAllFormat([$message]);
	}

	public function update(){

		if(!$this->requireAuthenticated() || !$this->requireAdminRole()){
			return ;
		}

		$parameters = $this->request->getParameters();

		if(!empty($parameters['id'])){

			$returnedMessage = $this->em->getRepository('\Entity\Message')->findBy(['id' => $parameters['id']]);

			$message = $returnedMessage[0];

			$message->setMessage($parameters['message']);

			$this->em->merge($message);
			$this->em->flush();

		}
	}

	private function returnAllFormat($messages, $type = null){

		// $formattedMessages = [];
		$formattedMessages = '';
		switch($type){
			case 'html':
				foreach($messages as $message){
					// $formattedMessages[] = '<li id="'.$message->getId().'"><div class="editable">'.$message->getMessage().'</div></li>';
					$formattedMessages.= '<div id="'.$message->getId().'"><div>'.$message->getCreatedAt()->format('m/d/Y H:i:s').'</div><div class="editable">'.$message->getMessage().'</div></div></br>';

				}
				break;
			default:
				foreach($messages as $message){
					$formattedMessages[] = [
						'id' => $message->getId(),
						'message' => $message->getMessage(),
						'createdAt' => $message->getCreatedAt()->format('m/d/Y H:i:s')
					];
				}
				$formattedMessages = json_encode($formattedMessages);
		}

		return $formattedMessages;
	}

	public function getMessages($verb=null){
		$messageList = '';
		$messageRecords = $this->em->getRepository("\Entity\Message")->findAll();

		echo $this->returnAllFormat($messageRecords, 'html');
	}

	public function getMessagesDirectedTo($directedTo){
		$messageList = '';
		$messageRecords = $this->em->getRepository("\Entity\Message")->findBy(['user' => $directedTo]);

		echo $this->returnAllFormat($messageRecords, 'json');
	}

} // end ChatController