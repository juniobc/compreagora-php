<?php

namespace Webservice\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


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
		//$router = $this->getServiceLocator()->get('Webservice\Model\ProdutoTable');
        return "Olá Mundo";
    }
    
    /**
     * @return string
     */
    public function welcame($nome) {
        return "Ola $nome, Seja bem vindo ao WebServer";
    }   
	
}