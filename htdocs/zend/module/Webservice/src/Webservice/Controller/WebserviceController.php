<?php

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;
use Webservice\Service\CadastroProduto;
use Webservice\Service\OlaMundo;
use Webservice\Model\Produto; 
use Webservice\Model\Endereco; 
use Webservice\Model\Empresa;
use Webservice\Model\Departamento;
use Webservice\Model\Entradaproduto;
 
class WebserviceController extends AbstractActionController{

	private $_WSDL_URI = "http://10.52.64.130/webservice/webservice/requisicao?wsdl";
	
	protected $produtoTable;
	protected $enderecoTable;
	protected $empresaTable;
	protected $departamentoTable;
	protected $entradaprodutoTable;

	public function indexAction(){
	
		exit(1);
	
	}
	 
	public function requisicaoAction(){
	
		if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }
        
        $view = new ViewModel();
        $view->setTerminal(true);
	
	}
	
	public function requisicao2Action(){
	
		if (isset($_GET['wsdl'])) {
            $this->handle2WSDL();
        } else {
            $this->handle2SOAP();
        }
        
        $view = new ViewModel();
        $view->setTerminal(true);
	
	}

	public function handleWSDL() {
        $autodiscover = new AutoDiscover();
        
        $autodiscover->setClass('\Webservice\Service\CadastroProduto');
        
        $autodiscover->setUri('http://10.52.64.130/webservice/webservice/requisicao');
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
