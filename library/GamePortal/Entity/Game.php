<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="GameRepository")
 * @ORM\Entity
 */
class Game
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
     * @var \Genre
     * 
     * @ORM\ManyToMany(targetEntity="Genre")  
     */
    private $genres;
    
    /**
     * @var \Platform
     *
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="games")    
     */
    private $platform;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=45, nullable=true)
     */
    private $cover;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="date", nullable=true)
     */
    private $releaseDate;
    
    
    /**
     * constructor
     */
    public function __construct() {
        $this->genres = new ArrayCollection();        
    }


}
