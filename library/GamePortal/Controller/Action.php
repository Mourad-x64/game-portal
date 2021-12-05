<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Action
 *
 * @author 2500K
 * 
 * 
 */
class GamePortal_Controller_Action extends Zend_Controller_Action {

    /**
     * Retrive the Doctrine Container.
     *
     * @return Bisna\Doctrine\Container
     */
    public function getDoctrineContainer() {
        return $this->getInvokeArg('bootstrap')->getResource('doctrine');
    }

    /**
     * Retrive the Doctrine Entity Manager.
     * 
     * @return \Doctrine\ORM\EntityManager 
     */
    public function getEntityManager() 
    {
        return $this->getDoctrineContainer()->getEntityManager();
    }
    
    /**
     * Retrive Zend logger firebug
     * 
     * @return Zend_Log
     */
    public function getLogger() 
    {
        return Zend_Registry::get('logger');
    }

}
