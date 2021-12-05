<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * view helper NewsWidget :
 * accède au news pour afficher 
 * les dernières news dans un widget réutilisable. 
 * 
 * @property Bisna\Doctrine\Container $container ***for code completion purpose***
 * @property Zend_Log $logger ***for code completion purpose***
 */
class GamePortal_View_Helper_NewsWidget extends Zend_View_Helper_Abstract {

    protected $container;
    protected $logger;   

    /**
     * 
     * génère le widget des news récentes
     * TODO :
     * ajouter les infobulles 
     * améliorer la mise en page
     * 
     * 
     * 
     */
    public function newsWidget() {
        $limit = 6;

        $this->container = Zend_Registry::get('doctrine');
        $this->logger = Zend_Registry::get('logger');

        $em = $this->container->getEntityManager();        

        $news_list = $em->getRepository('GamePortal\Entity\News')->getLatestNews($limit);        

        //$this->logger->log($news_list, Zend_Log::INFO);


        $date = '';
        $strong = '';

        $newsWidget = '<div class="gradientblock fleft">
            <h4>Toute l\'actualité</h4>
            <a href="' . $this->view->linkTo('index', 'news') . '" class="btn_see">Plus</a>
            <ul class="break_news">';
        
        
        foreach ($news_list as $news) {            
            /* si la news est d'aujourd'hui on la met en gras */
            $date = new Zend_Date($news[0]['date']->getTimestamp());
            $strong = '';
            if ($date->isToday()) {
                $strong = 'style="font-weight:bold"';
            }

            $newsWidget.=
                    '<li class="text-overflow">                
                    <a ' . $strong . ' href="' . $this->view->linkTo('display', 'news', NULL, array('id' => $news[0]['id'])) . '">'
                    . $this->view->escape($news[0]['title']) .
                    '</a>               
                    <h6>' . $this->view->escape('posté ' . $this->view->date(($news[0]['date']->getTimestamp()))) . '</h6>                    
                    <!--<a href="' . $this->view->linkTo('index', 'news') . '" class="read">Read more</a>-->
                    <br class="clear" />
                 </li>';
        }

        $newsWidget .=
                '   </ul>
         </div>
         <div class="clear"></div>';

        return $newsWidget;
    }

}
