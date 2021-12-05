<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GamePortal_View_Helper_BaseUrl extends Zend_View_Helper_Abstract
{
    /*
     * GamePortal baseUrl view helper 
     * 
     * returns the base url set in the ini config.
     * gamePortal.baseUrl = "xxxx" in application.ini
     * 
     * replaces antislashes with slashes.
     * adds '/' before the param path if document relative path is passed
     * or just returns the ini base url.
     * 
     * @param string $root_relative optional 
     * @return string ini base url or base url+param path     
     */
    public function baseUrl($root_relative = NULL)
    {        
        
        if(!empty($root_relative)){           
            
            $root_relative = preg_replace(array('#/{2,}#' , "#\\\{1,}#"), '/', $root_relative);
            
            if(substr_compare($root_relative, '/',0,1) != 0){
                $root_relative = '/'.$root_relative;
            }
        }        
        
        return Zend_Registry::get('config')->gamePortal->baseUrl.$root_relative;
    }
}