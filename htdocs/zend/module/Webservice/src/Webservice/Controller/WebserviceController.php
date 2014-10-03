<?php

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Webservice\Model\CadastraProduto;
 
class WebserviceController extends AbstractActionController{

	protected $cadastraProdutoTable;

	public function indexAction(){}
	
	public function requisicaoAction(){
	
		if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
           // $this->handleSOAP();
        }
        
        //$view = new ViewModel();
        //$view->setTerminal(true);
	
	}

	public function handleWSDL() {
        $autodiscover = new AutoDiscover();
        
        /**
         * Criamos um novo diretorio chamado Service e criamos a class OlaMundo
         * depois setamos a classe no autodiscover no metodo setClass
         */
        $autodiscover->setClass('\Webservice\Service\OlaMundo');
        
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
	
	public function getCadastraProdutoTable()
     {
         if (!$this->cadastraProdutoTable) {
             $sm = $this->getServiceLocator();
             $this->cadastraProdutoTable = $sm->get('Album\Model\CadastraProdutoTable');
         }
         return $this->cadastraProdutoTable;
     }
}
