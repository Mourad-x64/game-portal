<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Platform
 *
 * @ORM\Table(name="platform")
 * @ORM\Entity(repositoryClass="PlatformRepository")
 * @ORM\Entity
 */
class Platform
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
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Game", mappedBy="platform") 
     */
    private $games;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="platforms") 
     */
    private $articles;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=45, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, nullable=true)
     */
    private $color;
    
    
    /**
     * constructor
     */
    public function __construct() {
        $this->articles = new ArrayCollection();
        $this->games = new ArrayCollection(); 
    }


}
