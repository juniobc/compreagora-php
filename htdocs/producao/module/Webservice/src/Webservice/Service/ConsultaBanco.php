<?php

namespace Webservice\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Model\Produto;
use Application\Model\Endereco;
use Application\Model\Empresa;
use Application\Model\Departamento;
use Application\Model\Entradaproduto;
use Webservice\Service\TpEmpresa;
use Webservice\Service\ListaEmpresa;
use Webservice\Service\Envelope;

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
     * @return Webservice\Service\Envelope
     */
    public function listaEmpresa($latitude, $longitude)
    {
    	
    	$cont = 0;
    	$envelope = array('listaEmmpresa', 'erro');
    	$listaEmpresa = array('empresa');
    	$arrayEmpresa = array();
    	
    	$end_dados = new Endereco();
        
        $end_dados->exchangeArray(array('latitude'=>$latitude, 'longitude'=>$longitude));
    	
    	$row_emp = $this->getDepartamentoTable()->buscaDptoLatLong($end_dados);
    	
    	foreach ($row_emp as $row) :
    	    
    	    $empresa = array(
    	    
    	        'cd_empresa' => $row["id_dptoempresa"],
    	        'ds_empresa' => $row["descricao"],
    	        'distancia' => $row["distancia"]
    	    
    	    );
    	    
    	    $arrayEmpresa[] = $empresa;
    	    
    	    $cont = $cont + 1;
    	
    	endforeach;
    	
    	if($cont = 0){
    	    
    	    $envelope['erro'] = 'Não ha empresa cadastrada !';
    	    $envelope['numErro'] = 0;
    	    
    	}
    	
    	
    	$listaEmpresa['empresa'] = $arrayEmpresa;
    	$envelope['listaEmmpresa'] = $listaEmpresa;
		
		return $envelope;

    }
	
	private function getEnderecoTable()
     {
         if (!$this->enderecoTable) {
             $sm = $this->getServiceLocator();
             $this->enderecoTable = $sm->get('Application\Model\EnderecoTable');
         }
         return $this->enderecoTable;
     }
	 
	private function getEmpresaTable()
     {
         if (!$this->empresaTable) {
             $sm = $this->getServiceLocator();
             $this->empresaTable = $sm->get('Application\Model\EmpresaTable');
         }
         return $this->empresaTable;
     }
	 
	private function getDepartamentoTable()
     {
         if (!$this->departamentoTable) {
             $sm = $this->getServiceLocator();
             $this->departamentoTable = $sm->get('Application\Model\DepartamentoTable');
         }
         return $this->departamentoTable;
     }
	 
	private function getProdutoTable()
     {
         if (!$this->produtoTable) {
             $sm = $this->getServiceLocator();
             $this->produtoTable = $sm->get('Application\Model\ProdutoTable');
         }
         return $this->produtoTable;
     }
	 
	 private function getEntradaprodutoTable()
     {
         if (!$this->entradaprodutoTable) {
             $sm = $this->getServiceLocator();
             $this->entradaprodutoTable = $sm->get('Application\Model\EntradaprodutoTable');
         }
         return $this->entradaprodutoTable;
     }
	
}