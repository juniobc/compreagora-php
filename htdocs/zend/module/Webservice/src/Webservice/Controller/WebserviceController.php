<?php

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;	
 
class WebserviceController extends AbstractActionController{

	private $_WSDL_URI = "http://127.0.0.1:8080/webservice/webservice/requisicao?wsdl";

	public function indexAction(){}
	
	public function requisicaoAction(){
	
		if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }
        
        $view = new ViewModel();
        $view->setTerminal(true);
	
	}

	public function handleWSDL() {
        $autodiscover = new AutoDiscover();
        
        $autodiscover->setClass('\Webservice\Service\CadastroProduto');
        
        $autodiscover->setUri('http://127.0.0.1:8080/webservice/webservice/requisicao');
        $wsdl = $autodiscover->generate();
		$wsdl->dump("Soap/wsdl/file.wsdl");
        $wsdl = $wsdl->toDomDocument();
        
        echo $wsdl->saveXML();
    }
    
    public function handleSOAP() {
	
		$soap = new \Zend\Soap\Server($this->_WSDL_URI);
		$soap->setClass('\Webservice\Service\CadastroProduto');
		$soapObject = $this->getServiceLocator()->get('cadastroProduto');
		$soap->setObject($soapObject);
		
		$soap->handle();
    }
	
}
