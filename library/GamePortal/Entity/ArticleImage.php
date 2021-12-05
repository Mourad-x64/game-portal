<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleImage
 *
 * @ORM\Table(name="article_image")
 * @ORM\Entity(repositoryClass="ArticleImageRepository")
 * @ORM\Entity 
 */
class ArticleImage
{    
    /**
     * @var integer $id
     *  
     * @ORM\Id 
     * @ORM\Column(name="id", type="integer", nullable=false) 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="images")     
     */
    private $article;
    
}
