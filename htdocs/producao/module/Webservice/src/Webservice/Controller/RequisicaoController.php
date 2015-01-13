<?php

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;
use Webservice\Service\CadastroProduto;
use Webservice\Service\ConsultaBanco;

class RequisicaoController extends AbstractActionController{

	private $_WSDL_URI;
	private $class;
	private $uri;
	private $arquivo;
	
	public function cadastroProdutoAction(){
		
		$this->class = '\Webservice\Service\CadastroProduto';
		$this->uri = 'http://quero-c9-juniobc.c9.io/htdocs/producao/public/webservice/requisicao/cadastroproduto';
		$this->arquivo = 'public/soap/wsdl/cadastroproduto.wsdl';
		$this->smObjeto = 'cadastroprodutoWS';
		$this->_WSDL_URI = "http://quero-c9-juniobc.c9.io/htdocs/producao/public/webservice/requisicao/cadastroproduto?wsdl";
		
		$this->handler();
		
		return $this->response;
	
	}
	
	public function consultaBancoAction(){
		
		$this->class = '\Webservice\Service\ConsultaBanco';
		$this->uri = 'http://quero-c9-juniobc.c9.io/htdocs/producao/public/webservice/requisicao/consultabanco';
		$this->arquivo = 'public/soap/wsdl/consultabanco.wsdl';
		$this->smObjeto = 'consultabancoWS';
		$this->_WSDL_URI = "http://quero-c9-juniobc.c9.io/htdocs/producao/public/webservice/requisicao/consultabanco?wsdl";
		
		$this->handler();
		
		return $this->response;
	
	}
	
	public function handler(){
		
		if (isset($_GET['wsdl'])) {
            $this->wsdl();
        } else {
            $this->soap();
        }
        
        $view = new ViewModel();
        $view->setTerminal(false);
		
	}
	
	public function wsdl(){
		
		$autodiscover = new AutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeComplex());
		
        $autodiscover->setClass($this->class);
        
        $autodiscover->setUri($this->uri);
        
        $wsdl = $autodiscover->generate();
		$wsdl->dump($this->arquivo);
        $wsdl = $wsdl->toDomDocument();
        
        echo $wsdl->saveXML();
		
		
	}
	
	public function soap(){
		
		$soap = new \Zend\Soap\Server($this->_WSDL_URI, array('cache_wsdl' => WSDL_CACHE_NONE));
		$soap->setClass($this->class);
		$soapObject = $this->getServiceLocator()->get($this->smObjeto);
		$soap->setObject($soapObject);
		
		$soap->handle();
		
		
	}
	
}
