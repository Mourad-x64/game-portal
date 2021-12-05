<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Javascript
 *
 * @author 2500K
 */
class GamePortal_View_Helper_Javascript extends Zend_View_Helper_Abstract {

    public function javascript() {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = '/js/' . $request->getControllerName() . '/' . $request->getActionName() . '.js';
        $result = '';       

        if (file_exists(DOCUMENT_ROOT . $file_uri)) {

            $result .= $this->view->headScript()->appendFile($this->view->baseUrl($file_uri)).'\n';
        }
        
        return $result;
    }

}
