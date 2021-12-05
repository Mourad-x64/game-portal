<?php
namespace GamePortal\Entity;


/**
 * 
 */
class ArticleImageTest extends \ModelTestCase
{    
    public function testCanCreateArticleImage (){
        $this->assertInstanceOf('GamePortal\Entity\ArticleImage',new ArticleImage());        
    }

}
