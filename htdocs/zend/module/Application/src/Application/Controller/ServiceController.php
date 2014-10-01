<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;

class ServiceController extends AbstractActionController{
    // Armazena na variável o endereço do webserver no servidor
    private $_WSDL_URI = "http://127.0.0.1/application/service?wsdl";
    
    public function indexAction() {
        
        /* 
         * verifica se for passado o parametro url wsdl
         * se passado o parâmetro acessamos a função handleWSDL 
         * e carregamos as funções, pois retornaremos o WSDL
         */
        if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }
        
        $view = new ViewModel();
        $view->setTerminal(true);
        exit();
    }
    
    public function handleWSDL() {
        $autodiscover = new AutoDiscover();
        
        /**
         * Criamos um novo diretorio chamado Service e criamos a class OlaMundo
         * depois setamos a classe no autodiscover no metodo setClass
         */
        $autodiscover->setClass('\Application\Service\OlaMundo');
        
        // Setamos o Uri de retorno sem o parâmetro ?wdsl
        $autodiscover->setUri('http://127.0.0.1/application/service');
        $wsdl = $autodiscover->generate();
		$wsdl->dump("Soap/wsdl/file.wsdl");
        $wsdl = $wsdl->toDomDocument();
        
        // geramos o XML dando um echo no $wsdl->saveXML() 
        echo $wsdl->saveXML();
    }
    
    public function handleSOAP() {
        $soap = new \Zend\Soap\Server($this->_WSDL_URI);
        
        /**
         * Criamos um novo diretorio chamado Service e criamos a class OlaMundo
         * depois setamos a classe no autodiscover no metodo setClass
         */
        $soap->setClass('\Application\Service\OlaMundo');
        
        // Leva pedido do fluxo de entrada padrão
        $soap->handle();
    }    
}