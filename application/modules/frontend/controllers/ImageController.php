<?php

/**
 * TODO : !!! LIMITER LES REQUETES D IMAGES A UN SEUL DOMAINE (celui du site concerné !) !!!
 * Afin d'éviter que d'autres sites web n'utilisent votre serveur pour générer les images.
 * Evite aussi les surcharge ou attaques par ce biais. 
 * Utiliser aussi la réecriture d'url ou changer les routes zend.
 * 
 * ne pas oublier la mise en cache des images.
 */
class ImageController extends Zend_Controller_Action {
    
    /**
     *
     * @var type 
     */
    protected $_logger;

    public function init() {
        /* Initialize action controller here */
        parent::init();
        
        // init logger
        $this->_logger = Zend_Registry::get('logger'); 

        // rend le controller aveugle (n'a pas de view)
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
    }

    public function indexAction() {
        // récupération des paramètres de la requète :
        $filepath = urldecode($this->_getParam('file'));        
        $w = (int) $this->_getParam('w');
        $h = (int) $this->_getParam('h');

        // traitement de l'image :
        $image = $this->_helper->image($filepath);

        // création de la miniature et rendu :
        $image->thumbnail($w, $h)->render();
        
        $debugInfo = $filepath.' - '.$image->getWidth().'px  x '.$image->getHeight().'px';
        
        // envoi des infos d'images dans le log firebug :        
        //$this->_logger->log($debugInfo, Zend_Log::INFO);
        
        
    }

}
