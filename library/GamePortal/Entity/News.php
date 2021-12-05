<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * News
 *
 * @ORM\Entity(repositoryClass="GamePortal\Entity\Repository\NewsRepository")
 * @ORM\Table(name="news") 
 * 
 */
class News
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
     * @var \Platform
     * 
     * @ORM\ManyToMany(targetEntity="Platform", inversedBy="news")  
     */
    private $platforms;
    
    /**
     * @var \Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="news") 
     */
    private $comments;
    
    /**
     * @var \NewsImage
     *
     * @ORM\OneToMany(targetEntity="NewsImage", mappedBy="news") 
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

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
        $this->comments = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->images = new ArrayCollection();
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
    
    
    
    public function getId() {
        return $this->id;
    }

    public function getPlatforms() {
        return $this->platforms;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getImages() {
        return $this->images;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDate() {
        return $this->date;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCatchImage() {
        return $this->catchImage;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPlatforms(\Plateform $platforms) {
        $this->platforms = $platforms;
    }

    public function setComments(\Comment $comments) {
        $this->comments = $comments;
    }

    public function setImages(\NewsImage $images) {
        $this->images = $images;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCatchImage($catchImage) {
        $this->catchImage = $catchImage;
    }




}
