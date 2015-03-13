<?php
/**
 * funcao: Pagina inicial do sistema
 * autor: Sebastiao Junio
 * Data: 25/02/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.econoom.com.br)
 * 
 */

namespace Compracerta\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json as Jason;
use Zend\View\Model\JsonModel;


class HomeController extends AbstractActionController{
    
    protected $storage;
    protected $authservice;
    
    public function indexAction(){
        
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        
        
    }
    
    public function loginAction(){
        
        $response = $this->getResponse();
        
        $msg = $this->flashmessenger()->getMessages();
        
        //$this->flashmessenger()->clearMessages();
        
         //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            //return $this->redirect()->toRoute('success');
            //return $this->redirect()->toRoute('inicio', array('action' => 'areatrabalho'));
            $response->setContent(json_encode(array("errors"=>"", 'redirect'=> $this->url()->fromRoute('inicio'))));
        }else{
            $response->setContent(json_encode(array("errors"=>$msg)));
        }
        //$response->setContent($result);
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
    
        return $response;
        
        
    }
    
    public function authenticateAction(){
        
        $redirect = 'login';
        $return = 0;
         
        $request = $this->getRequest();
        if ($request->isPost()){
            
            if($request->getPost('username') == ""){
                
                $this->flashmessenger()->addMessage("O campo usuário não pode estar vazio !");
                $return = 1;
                
                
            }
            
            if($request->getPost('password') == ""){
                
                $this->flashmessenger()->addMessage('O campo senha não pode estar vazio !');
                $return = 1;
                
                
            }
            
            if($return == 1){
                
                return $this->redirect()->toRoute('home', array('action' => $redirect));
                
            }
               
            $this->getAuthService()->getAdapter()
                                   ->setIdentity($request->getPost('username'))
                                   ->setCredential($request->getPost('password'));
                                    
            $result = $this->getAuthService()->authenticate();
            foreach($result->getMessages() as $message)
            {
                //save message temporary into flashmessenger
                $this->flashmessenger()->addMessage($message);
            }
             
            if ($result->isValid()) {
                
                //check if it has rememberMe :
                if ($request->getPost('rememberme') == 'on' ) {
                    
                    $this->getSessionStorage()
                         ->setRememberMe(1);
                    //set storage again      
                    $this->getAuthService()->setStorage($this->getSessionStorage());
                }
                $this->getAuthService()->getStorage()->write($request->getPost('username'));
            }
            
        }
         
        return $this->redirect()->toRoute('home', array('action' => $redirect));
        
    }
     
    public function logoutAction(){
        
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
         
        $this->flashmessenger()->addMessage("Usuário desconectado !");
        return $this->redirect()->toRoute('home', array('action' => 'index'));
        
    }
    
    public function getAuthService(){
        
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
         
        return $this->authservice;
    }
    
    public function getSessionStorage(){
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Compracerta\Storage\AuthStorage');
        }
        
        return $this->storage;
    }
	
}