<?php

namespace Webservice\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Webservice\Model\Produto; 
use Webservice\Model\Endereco; 
use Webservice\Model\Empresa;
use Webservice\Model\Departamento;
use Webservice\Model\Entradaproduto;
use Webservice\Service\Tipoempresa; 

class ConsultaBanco implements ServiceLocatorAwareInterface{

	protected $sm;
	protected $produtoTable;
	protected $enderecoTable;
	protected $empresaTable;
	protected $departamentoTable;
	protected $entradaprodutoTable;	

	 public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->sm;
    }
    
    /**
     * 
     * @return Empresa
     */
    public function listaEmpresa()
    {
        
        $msg = array();
        $cont = 0;
    	
    	$row_emp = $this->getDepartamentoTable()->buscaEmpresaLatLong(-16.70233453, -49.22747316);
    	
    	if(!$row_emp){
    	    
    	    $msg[0] = "Nenhuma empresa encontrada";
    	    
    	}else{
    	    
    	    foreach($row_emp as $row) :
		
    			$msg["empresa-".$cont] = $row;
    			
    			$cont = $cont + 1;
		    
		    endforeach;
    	    
    	}
    	
		return $msg;
		
    }
	
	private function getEnderecoTable()
     {
         if (!$this->enderecoTable) {
             $sm = $this->getServiceLocator();
             $this->enderecoTable = $sm->get('Webservice\Model\EnderecoTable');
         }
         return $this->enderecoTable;
     }
	 
	private function getEmpresaTable()
     {
         if (!$this->empresaTable) {
             $sm = $this->getServiceLocator();
             $this->empresaTable = $sm->get('Webservice\Model\EmpresaTable');
         }
         return $this->empresaTable;
     }
	 
	private function getDepartamentoTable()
     {
         if (!$this->departamentoTable) {
             $sm = $this->getServiceLocator();
             $this->departamentoTable = $sm->get('Webservice\Model\DepartamentoTable');
         }
         return $this->departamentoTable;
     }
	 
	private function getProdutoTable()
     {
         if (!$this->produtoTable) {
             $sm = $this->getServiceLocator();
             $this->produtoTable = $sm->get('Webservice\Model\ProdutoTable');
         }
         return $this->produtoTable;
     }
	 
	 private function getEntradaprodutoTable()
     {
         if (!$this->entradaprodutoTable) {
             $sm = $this->getServiceLocator();
             $this->entradaprodutoTable = $sm->get('Webservice\Model\EntradaprodutoTable');
         }
         return $this->entradaprodutoTable;
     }
	
}