<?php
use \Entity\Message;

class ChatController extends MainController{


	/** **/
	public function index(){

		$chatMessages = '';

		$chatMessages = $this->formatChatMessages();
		include VIEWS."chat.html";
	}

	protected function formatChatMessages(){

		$allMessagesInChat = '';

		$messages = $this->em->getRepository("\Entity\Message")->findAll();
		foreach ($messages as $message) {

			$allMessagesInChat .=
			  '<div id="'.$message->getId().'"><div>'.$message->getCreatedAt()->format('m/d/Y H:i:s').'</div><div class="editable">'.$message->getMessage().'</div></div></br>';
		}
		return $allMessagesInChat;
	}

} // end ChatController