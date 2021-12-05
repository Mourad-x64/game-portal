<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity(repositoryClass="GenreRepository")
 * @ORM\Entity
 */
class Genre
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
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;


}
