<?php
// Test.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="message", indexes={
*     @ORM\Index(name="messageToUser", columns={"user_id"})
* })
*/
class Message {

	/**
	* @ORM\Id()
	* @ORM\Column(name="message_id", type = "integer")
	* @ORM\GeneratedValue(strategy = "AUTO")
	* @var int
	*/
	protected $id;

	/**
     * @var string
     * @ORM\Column(name="message", type="text", nullable=false)
	*/
	protected $message;

	/**
     * @var string
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
	*/
	protected $createdAt;

	/**
     * @var string
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=false)
	*/
	protected $modifiedAt;

    /**
     * @var user
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

	public function __construct($message) {
		$this->message = $message;
		$this->createdAt = new \DateTime();
		$this->modifiedAt = new \DateTime();
	}


	/**
	*
	* @return string
	*/
	public function getMessage() {
		return $this->message;
	}

	/**
	*
	* @return int
	*/
	public function getId() {
		return $this->id;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function getModifiedAt() {
		return $this->modifiedAt;
	}

}