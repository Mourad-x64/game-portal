<?php

namespace GamePortal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestImage
 *
 * @ORM\Table(name="test_image")
 * @ORM\Entity(repositoryClass="TestImageRepository")
 * @ORM\Entity
 */
class TestImage
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
     * @var Test
     *
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="images")     
     */
    private $test;

}
