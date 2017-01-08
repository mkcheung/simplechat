<?php
use \Entity\Message;

class MessagesController extends MainController{

	public function determineAction($verb){
		switch($verb){
			case 'GET':
				$methodCall = 'getMessages';
				break;
			case 'POST':
				$methodCall = 'addMessage';
				break;
			default:
		}
		$this->$methodCall($verb);

	}

	public function addMessage(){
		$incomingMessage = $_POST['message'];
		$message = new Message($incomingMessage);
		$this->em->persist($message);
		$this->em->flush();

		//echo json_encode(array('id' => $message->id));
 		echo $this->returnAllFormat([$message]);
	}

	private function returnAllFormat($messages, $type = null){

		$formattedMessages = [];
		switch($type){
			case 'html':
				foreach($messages as $message){
					$formattedMessages[] = '<li>'.$message->getMessage().'</li>';
				}
				break;
			default:
				foreach($messages as $message){
					$formattedMessages[] = [
						'id' => $message->getId(),
						'message' => $message->getMessage(),
						'createdAt' => $message->getCreatedAt()->format('Y/m/D H:i:s')
					];
				}
				$formattedMessages = json_encode($formattedMessages);
		}

		return $formattedMessages;
	}

	public function getMessages($verb=null){
		$messageList = '';
		//why did I have to spell out the namespace here?
		$messageRecords = $this->em->getRepository("\Entity\Message")->findAll();
		echo $this->returnAllFormat($messageRecords);
	}

} // end ChatController