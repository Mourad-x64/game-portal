<?php

class IndexController extends Zend_Controller_Action
{
    protected $doctrineContainer;


    public function init() {
        
        /* Initialize action controller here */
        
        $this->view->headTitle()->append('Home');
        
    }

    public function indexAction()
    {
        
    }


}

