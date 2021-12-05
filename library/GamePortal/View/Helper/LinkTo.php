<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * helper pour les liens
 * 
 */

class GamePortal_View_Helper_LinkTo extends Zend_View_Helper_Abstract
{  
    
    public function linkTo($action='index', $controller=null, $module=null, $params=null)  {
        
        $opts = array();

        $opts['action'] = $action;
        $opts['controller'] = $controller;
        $opts['module'] = $module;

        if ($params){
            foreach ($params as $key => $value){
                $opts[$key] = $value;
            }
        }

        $router = Zend_Controller_Front::getInstance()->getRouter();
        $url = $router->assemble($opts, null, true);

        return $url;       
        
    }    
    
}
