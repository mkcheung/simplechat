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
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_id")
	 */
	protected $createdBy;

    /**
     * @var user
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

	public function __construct($message, $createdBy, $directedToUser='') {
		$this->message = $message;
		$this->createdBy = $createdBy;
		$this->user = (!empty($directedToUser)) ? $directedToUser : null;

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

	public function setMessage($message) {
		$this->message = $message;
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