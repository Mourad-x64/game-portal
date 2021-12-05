<?php

class NewsController extends GamePortal_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();

        $this->view->headTitle()->append('News');        
        
    }

    public function indexAction() {
        // rendu de la page d'accueil des news              
        
        
//        $style = 'position:relative; overflow:hidden; float:left; margin-left:10px; margin-bottom:50px; border:3px solid black;';
//
//        $this->view->bla = // encart carré
//                '<div style="width:178px; height:178px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'square - mini.jpg', 'w' => 178, 'h' => 178)) . '" /></div>
//            <div style="width:178px; height:178px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'paysage - mini.jpg', 'w' => 178, 'h' => 178)) . '" /></div>
//            <div style="width:178px; height:178px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'portrait.jpg', 'w' => 178, 'h' => 178)) . '" /></div>
//                <div style="width:178px; height:178px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'alpha_png - mini.png', 'w' => 178, 'h' => 178)) . '" /></div>
//            <div class="clear"></div><br/>';
//        $this->view->bla .=
//                // encarte paysage
//                '<div style="width:213px; height:143px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'square - mini.jpg', 'w' => 213, 'h' => 143)) . '" /></div>
//            <div style="width:213px; height:143px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'paysage - mini.jpg', 'w' => 213, 'h' => 143)) . '" /></div>
//            <div style="width:213px; height:143px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'portrait.jpg', 'w' => 213, 'h' => 143)) . '" /></div>
//                <div style="width:213px; height:143px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'alpha_png - mini.png', 'w' => 213, 'h' => 143)) . '" /></div>
//            <div class="clear"></div><br/>';
//        $this->view->bla .=
//                // encarte portrait
//                '<div style="width:143px; height:213px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'square - mini.jpg', 'w' => 143, 'h' => 213)) . '" /></div>
//            <div style="width:143px; height:213px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'paysage - mini.jpg', 'w' => 143, 'h' => 213)) . '" /></div>
//            <div style="width:143px; height:213px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'portrait.jpg', 'w' => 143, 'h' => 213)) . '" /></div>
//                <div style="width:143px; height:213px; ' . $style . '"><img src="' . $this->view->linkTo('index', 'image', NULL, array('file' => 'alpha_png - mini.png', 'w' => 143, 'h' => 213)) . '" /></div>
//            <div class="clear"></div><br/>';
               
        
        //permet de récupérer le chemin complet d'un dossier image
        $this->view->path = $this->view->baseUrl(Zend_Registry::get('config')->assets->images->path->news);
        //list des news par date
        $this->view->newsList = $this->getEntityManager()->getRepository('GamePortal\Entity\News')->getLatestNews(5);    
        
        
    }

    public function displayAction() {
        //permet d'affecter une vue différente à une action
        //$this->_helper->viewRenderer->setScriptAction('index');

        $this->view->bla = "display the correct news ";
    }

}
