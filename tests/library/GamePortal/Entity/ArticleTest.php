<?php

namespace GamePortal\Entity;


/**
 * 
 */
class ArticleTest extends \ModelTestCase
{    
    public function testCanCreateArticle (){
        $this->assertInstanceOf('GamePortal\Entity\Article',new Article());        
    }
    
    public function testCanSaveArticlesAndRetriveThem(){
        
        $a = new Article();
        $a->setTitle('Oculus VR');
        $a->date = new \DateTime('now');
        $a->catchImage = 'test/test/test';
        
        $this->em->persist($a);
        $this->em->flush();       
        
        $articles = $this->em->createQuery('SELECT a FROM GamePortal\Entity\Article a')->execute();
        $this->assertEquals(1, count($articles));
        $this->assertEquals('Oculus VR', $articles[0]->getTitle());
        $this->assertEquals('test/test/test', $articles[0]->catchImage);      
        
    }

}