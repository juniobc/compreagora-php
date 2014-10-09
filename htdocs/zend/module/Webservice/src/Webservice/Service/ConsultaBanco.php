<?php

namespace Webservice\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Webservice\Model\Produto; 
use Webservice\Model\Endereco; 
use Webservice\Model\Empresa;
use Webservice\Model\Departamento;
use Webservice\Model\Entradaproduto;


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
     * @return string
     */
    public function listaEmpresa()
    {
    	
    	
    	
		return "eu to aqui2";
		
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