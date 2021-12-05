<?php

class Plugin_Auth extends Zend_Controller_Plugin_Abstract {

    protected $_defaultRole = 'guest';

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        /*
         * TODO : bug fix
         * génère un message d'erreur quand on tente d'accéder
         * à une ressource non mentionnée dans l' ACL (ex: news/index). 
         *          
         */
        $auth = Zend_Auth::getInstance();
        $acl = new GamePortal_Acl();
        $mysession = new Zend_Session_Namespace('mysession');
        $ressource = $request->getControllerName() . '::' . $request->getActionName();

        if ($acl->has($ressource)) {

            if ($auth->hasIdentity()) {
                $user = $auth->getIdentity();
                if (!$acl->isAllowed($user->role, $ressource)) {
                    $mysession->destination_url = $request->getPathInfo();

                    return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoUrl('auth/noauth');
                }
            } else {
                if (!$acl->isAllowed($this->_defaultRole, $ressource)) {
                    $mysession->destination_url = $request->getPathInfo();

                    return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoUrl('auth/login');
                }
            }
        }
        
    }

}
