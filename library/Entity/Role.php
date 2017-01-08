<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\DateTimeType;
/**
* @ORM\Entity
* @ORM\Table(name="role")
*/
class Role {

	/**
	* @ORM\Id()
	* @ORM\Column(name="role_id", type = "integer")
	* @ORM\GeneratedValue(strategy = "AUTO")
	* @var int
	*/
	protected $id;

	/**
	* @ORM\Column (type = "string", length = 255)
	* @var string
	*/
	protected $type;
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
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    protected $users;

	public function __construct($type) {

		$date = new \DateTime();
		$this->type = $type;
		$this->users     = new ArrayCollection();
		$this->createdAt = $date;
		$this->modifiedAt = $date;
	}

	/**
	*
	*/
	public function setType($type) {
		$this->type = $type;
	}

	/**
	*
	* @return string
	*/
	public function getType() {
		return $this->type;
	}

	public function getId() {
		return $this->id;
	}
}