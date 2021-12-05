<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="CommentRepository")
 * @ORM\Entity
 */
class Comment
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
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")    
     */
    private $article;

    /**
     * @var \News
     *
     * @ORM\ManyToOne(targetEntity="News", inversedBy="comments")     
     */
    private $news;

    /**
     * @var \Tests
     *
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="comments")     
     */
    private $test;

}
