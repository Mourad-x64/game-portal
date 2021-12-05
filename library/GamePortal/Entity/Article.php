<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ArticleRepository")
 * @ORM\Entity
 */
class Article 
{    
    /**
     * @var integer $id
     *  
     * @ORM\Id 
     * @ORM\Column(name="id" , type="integer" , nullable=false) 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \Platform
     * 
     * @ORM\ManyToMany(targetEntity="Platform", inversedBy="articles")  
     */
    private $platforms;
    
    /**
     * @var \ArticleImage
     *
     * @ORM\OneToMany(targetEntity="ArticleImage", mappedBy="article") 
     */
    private $images;
    
    /**
     * @var \Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="Article") 
     */
    private $comments;

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
     * constructor
     */
    public function __construct() {
        $this->images = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
    
    
    /* getters/setters */
    
    public function getTitle() {
        return $this->title;
    }

    public function getDate() {
        return $this->date;
    }

    public function getCatchImage() {
        return $this->catchImage;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    public function setCatchImage($catchImage) {
        $this->catchImage = $catchImage;
    }
        

    /**
     * magic getter
     * 
     * @param type $property
     * @return type
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * magic setter
     * 
     * @param type $property
     * @param type $value
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

}
