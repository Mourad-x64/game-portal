<?php

/*
 * les methodes protected qui commencent par _initSuffixe
 * sont appelées automatiquement dans l'index.php
 * par ->bootstrap('Suffixe')...;
 * 
 * si Suffixe n'est pas passé en paramètre toute les 
 * fonctions _init sont appelées.
 * 
 * si une fonction _init retourne une valeure, celle ci est
 * stockée dans le bootstrap container (zend registry) 
 * 
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoload() {

        $loader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH));
        
        
        return $loader;
    }
    
//    protected function _initPlugins()
//    {
//        $objFront = Zend_Controller_Front::getInstance();
//        $objFront->registerPlugin(new GamePortal_Controller_Plugin_ACL(), 1);
//        return $objFront;
//    }
    
    /**
     * pour bisna/doctrine2 intégration
     * 
     */
    protected function _initComposerAutoloader()
    {
        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $composerAutoloader = require_once LIBRARY_PATH. '/vendor/autoload.php';
        $loader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($loader, 'loadClass'), 'Bisna');        
    }

    protected function _initConfig() {
        //permet d'accéder au fichier de config dans toute l'application
        //Filter data by environement value (production, staging, testing, development)
        $config = new Zend_Config($this->getOptions());

        Zend_Registry::set('config', $config);
    }

    protected function _initActionHelpers() {
        //ajout des custom action helpers
        Zend_Controller_Action_HelperBroker::addPath(
                LIBRARY_PATH . '/GamePortal/Controller/Action/Helper', 'GamePortal_Controller_Action_Helper'
        );
    }

    /**
     * intitialiser le writer de firebug (firephp):
     * permet d'afficher des log dans la console de firebug. 
     * (pratique pour débugger)
     * 
     * 
     */
    protected function _initWriter() {

        $writer = new Zend_Log_Writer_Firebug();
        $logger = new Zend_Log($writer);

        //enregistre le logger dans zend_registry pour pouvoir y accéder partout.
        Zend_Registry::set('logger', $logger);

        //désactivation du logger en production :
        if (APPLICATION_ENV != 'development') {
            $writer->setEnabled(FALSE);
        }    
        
    }

    /**
     * intitialiser le profiler de firebug (firephp):
     * All DB queries in the model, view and controller
     * files will now be profiled and sent to Firebug console
     * (pratique pour débugger)
     */
    protected function _initProfiler() {
        /*
        $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
        $profiler->setEnabled(true);

        //get the db adapter
        $dbResource = $this->getPluginResource('db');
        $db = $dbResource->getDbAdapter();

        // Attach the profiler to the db adapter
        $db->setProfiler($profiler);

        //désactivation du profileur en production :
        if (APPLICATION_ENV != 'development') {
            $profiler->setEnabled(FALSE);
        }
         * 
         */
    }

    protected function _initView() {

        $view = new Zend_View();
        $view->doctype('XHTML1_TRANSITIONAL');

        // ajout des custom view helpers (accès cross module) 
        $view->addHelperPath(LIBRARY_PATH . '/GamePortal/View/Helper', 'GamePortal_View_Helper');
        // implémentation du jquery helper pour toute l'application
        $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();

        $view->headTitle('Game Portal')->setSeparator(' - ');

        return $view;
    }

}
