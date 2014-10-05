<?php

namespace Webservice\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;
use Webservice\Model\Produto; 


class CadastroProduto implements ServiceLocatorAwareInterface{

	protected $sm;

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
    public function OlaMundo()
    {
	
		$produtos = $this->getProdutoTable()->fetchAll();
	
		foreach ($produtos as $produto) :
		
			$teste = $produto->ds_produto;
		
		endforeach;
	
		return $teste;
    }
    
    /**
     * @return string
     */
    public function welcame($nome) {
        return "Ola $nome, Seja bem vindo ao WebServer";
    }   
	
	public function getProdutoTable(){
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Webservice\Model\ProdutoTable');
         }
         return $this->albumTable;
    }
	
}