<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsImages
 *
 * @ORM\Table(name="news_image")
 * @ORM\Entity(repositoryClass="NewsImageRepository")
 * @ORM\Entity
 */
class NewsImage
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer" , nullable=false)     
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="News", inversedBy="images")     
     */
    private $news;

}
