<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\DateTimeType;
/**
* @ORM\Entity
* @ORM\Table(name="user")
*/
class User {

	/**
	* @ORM\Id()
	* @ORM\Column(name="user_id", type = "integer")
	* @ORM\GeneratedValue(strategy = "AUTO")
	* @var int
	*/
	protected $id;

	/**
	* @ORM\Column (type = "string", length = 255)
	* @var string
	*/
	protected $username;

	/**
	* @ORM\Column (type = "string", length = 255)
	* @var string
	*/
	protected $password;


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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
     */
    protected $sentMessages;

    /**
     * @var role
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="role_id")
     */
    protected $role;


	public function __construct($username, $password, $role) {

		$date = new \DateTime();
		$this->username = $username;
		$this->setPassword($password);
		$this->messages     = new ArrayCollection();
		$this->createdAt = $date;
		$this->modifiedAt = $date;
		$this->role = $role;
		// $orm = $this->getDoctrine()->getManager();
	}

	/**
	* @param string $content
	*/
	public function setPassword($password) {
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}
	/**
	* @param string $content
	*/
	public function getPassword() {
		return $this->password;
	}

	/**
	*
	* @return string
	*/
	public function getUserName() {
		return $this->username;
	}

	/**
	*
	* @return string
	*/
	public function setUserName($username) {
		$this->username = $username;
	}

	/**
	*
	* @return int
	*/
	public function getId() {
		return $this->id;
	}

	/**
	*
	* @return Role
	*/
	public function getRole() {
		return $this->role;
	}
}