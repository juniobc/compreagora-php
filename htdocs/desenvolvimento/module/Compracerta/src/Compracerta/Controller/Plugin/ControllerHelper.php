<?php

namespace Compracerta\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ControllerHelper extends AbstractPlugin{
    
    public function envia_json($dados){
        
        $response = $this->getResponse();
            
        $response->setContent(json_encode($dados));
        //$response->setContent($result);
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
    
        return $response;
        
    }
    
}