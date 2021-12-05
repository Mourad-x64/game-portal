<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Css
 *
 * @author 2500K
 */
class GamePortal_View_Helper_Css extends Zend_View_Helper_Abstract {

    public function css() {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = '/css/' . $request->getControllerName() . '/' . $request->getActionName() . '.css';

        if (file_exists(DOCUMENT_ROOT . $file_uri)) {
            return $this->view->headLink()->appendStylesheet($this->view->baseUrl($file_uri));
        }
    }

}
