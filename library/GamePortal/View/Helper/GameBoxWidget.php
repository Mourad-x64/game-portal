<?php


/** 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @property Bisna\Doctrine\Container $container ***for code completion purpose***
 * @property Zend_Log $logger ***for code completion purpose***
 */
class GamePortal_View_Helper_GameBoxWidget extends Zend_View_Helper_Abstract
{
    
    protected $container;
    protected $logger;   
    
    
    public function gameBoxWidget(){
        /**
         * 
         * TODO : changer la requète pour afficher 
         * un mélange des contenus récents de la bdd (news,test,articles...).
         * 
         */
        $limit = 5;

        $this->container = Zend_Registry::get('doctrine');
        $this->logger = Zend_Registry::get('logger');

        $em = $this->container->getEntityManager();       

        $news_list = $em->getRepository('GamePortal\Entity\News')->getLatestNews($limit);        

        //$this->logger->log($news_list, Zend_Log::INFO);        
        
        $gameBoxWidget = 
        '
         <div class="greyblock right_spacing15 fleft" >
            <h4 class="ttl nomar">GameBox View</h4>            
            <ul class="gamebox_list">';        
    
            foreach ($news_list as $news){               
                
                $gameBoxWidget.= 
                '<li class="text-overflow">                
                    <a href="'.$this->view->linkTo('display','news',NULL,array('id'=>$news[0]['id'])).'">'
                        . ''.$this->view->escape($news[0]['title']).'           
                    </a><br />               
                    '.$this->view->escape($news[0]['content']).'                   
                 </li>';
            } 
     
        $gameBoxWidget .= 
        '   </ul>
            <a href="'.$this->view->linkTo('index','news').'" class="btn_see">Plus</a>
         </div>';
        
        return $gameBoxWidget;
    }
}