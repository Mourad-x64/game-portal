<?php

class AuthController extends GamePortal_Controller_Action {
    
    public function loginAction(){
        
        $form = new Application_Form_Login();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($_POST)) {
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                
                $authAdapter = new GamePortal_Doctrine_Auth_Adapter('GamePortal\Entity\User', 'u', 'username', 'password');                
                $authAdapter->setIdentity($data['username'])->setCredential($data['password']);
                $result = $auth->authenticate($authAdapter);
                
                //debug
                \Zend_Registry::get('logger')->log($result,\Zend_Log::INFO);
                
                if($result->isValid()) {
                    $storage = new Zend_Auth_Storage_Session();
                    $storage->write($authAdapter->getResultRowObject());
                    $mysession = new Zend_Session_Namespace('mysession');
                    if(isset($mysession->destination_url)) {
                        $url = $mysession->destination_url;
                        unset($mysession->destination_url);
                        $this->_redirect($url);
                    }
                    $this->_redirect('index/index');
                } else {
                    $this->view->errorMessage = "Invalid username or password. Please try again.";
                }
            }
        }        
    }
    
    public function logoutAction(){
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('index/index');
     }
}
