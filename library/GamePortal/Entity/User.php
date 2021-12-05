<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;


/**
 * User 
 * 
 * 
 * @ORM\Entity(repositoryClass="GamePortal\Entity\Repository\UserRepository")
 * @ORM\Table(name="user")  
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)     
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;   
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=false)
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    
    
    /**
     * constructor
     */
    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setCreated(\DateTime $created) {
        $this->created = $created;
    }

}
