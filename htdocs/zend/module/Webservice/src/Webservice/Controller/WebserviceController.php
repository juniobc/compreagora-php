<?php

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\AutoDiscover;
use Webservice\Service\CadastroProduto;
use Webservice\Service\ConsultaBanco;
use Webservice\Model\Produto; 
use Webservice\Model\Endereco; 
use Webservice\Model\Empresa;
use Webservice\Model\Departamento;
use Webservice\Model\Entradaproduto;
 
class WebserviceController extends AbstractActionController{

	private $_WSDL_URI = "http://quero-c9-juniobc.c9.io/htdocs/zend/public/webservice/webservice/requisicao?wsdl";
	
	protected $produtoTable;
	protected $enderecoTable;
	protected $empresaTable;
	protected $departamentoTable;
	protected $entradaprodutoTable;

	public function indexAction(){
		
		$row_emp = $this->getDepartamentoTable()->buscaEmpresaLatLong(-16.70233453, -49.22747316);
		
		foreach($row_emp as $row) :
		
    			$msg = $row['id_endereco'];
		
		endforeach;
		
		var_dump($msg);
	
		exit(1);
	
	}
	
	private function getDepartamentoTable()
     {
         if (!$this->departamentoTable) {
             $sm = $this->getServiceLocator();
             $this->departamentoTable = $sm->get('Webservice\Model\DepartamentoTable');
         }
         return $this->departamentoTable;
     }
	
	public function cadastro_produtoAction(){
	    echo "teste";
	   //exit(1);
	    
	}
	 
	public function requisicaoAction(){
	
		if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }
        
        $view = new ViewModel();
        $view->setTerminal(false);
	
	}
	
	public function consultaAction(){
	
		if (isset($_GET['wsdl'])) {
            $this->wsdl();
        } else {
            $this->soap();
        }
        
        $view = new ViewModel();
        $view->setTerminal(false); 
	
	}
	
	public function wsdl(){
		
		$wsdl = new Zend\Soap\Wsdl('My_Web_Service', $myWebServiceUri);
		$autodiscover = new AutoDiscover();
        $autodiscover->setClass('\Webservice\Service\ConsultaBanco');
        $autodiscover->setUri('http://quero-c9-juniobc.c9.io/htdocs/zend/public/webservice/webservice/consulta');
        $autodiscover->addComplexType(
			'Empresa',
			'complexType',
			'struct',
			'all',
			'',
			array(
				'Name' => array('name'=>'name','type'=>'xsd:string'),
				'Code' => array('name'=>'product_number','type'=>'xsd:string'),
				'Price' => array('name'=>'price','type'=>'xsd:string'),
				'Ammount' => array('name'=>'quantity','type'=>'xsd:string')
			)
		);
        $wsdl = $autodiscover->generate();
        
		$wsdl->dump("Soap/wsdl/consultabanco.wsdl");
        $wsdl = $wsdl->toDomDocument();
        
        echo $wsdl->saveXML();
		
		
	}
	
	public function soap(){
		
		$soap = new \Zend\Soap\Server('http://quero-c9-juniobc.c9.io/htdocs/zend/Soap/wsdl/consultabanco.wsdl');
		$soap->setClass('\Webservice\Service\ConsultaBanco');
		$soapObject = $this->getServiceLocator()->get('consultabanco');
		
		$soap->setObject($soapObject);
		
		$soap->handle();
		
		
	}

	public function handleWSDL() {
        $autodiscover = new AutoDiscover();
        
        $autodiscover->setClass('\Webservice\Service\CadastroProduto');
        
        $autodiscover->setUri('http://quero-c9-juniobc.c9.io/htdocs/zend/public/webservice/webservice/requisicao');
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
