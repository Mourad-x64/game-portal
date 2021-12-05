<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="TestRepository")
 * @ORM\Entity
 */
class Test
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
     * @var \Game
     *
     * @ORM\OneToOne(targetEntity="Game", inversedBy="test")    
     */
    private $game;
    
    /**
     * @var \Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="tests") 
     */
    private $comments;
    
    /**
     * @var \TestImage
     *
     * @ORM\OneToMany(targetEntity="TestImage", mappedBy="tests") 
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="catch_image", type="string", length=45, nullable=true)
     */
    private $catchImage;

    /**
     * @var string
     *
     * @ORM\Column(name="header_image", type="string", length=45, nullable=true)
     */
    private $headerImage;   
    

    /**
     * constructor
     */
    public function __construct() {
        $this->images = new ArrayCollection();        
        $this->comments = new ArrayCollection();
    }
    
}
