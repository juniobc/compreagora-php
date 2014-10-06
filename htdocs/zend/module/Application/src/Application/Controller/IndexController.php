<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Produto; 
use Application\Model\Endereco; 
use Application\Model\Empresa;
use Application\Model\Departamento;
use Application\Model\Entradaproduto;

class IndexController extends AbstractActionController
{

	protected $produtoTable;
	protected $enderecoTable;
	protected $empresaTable;
	protected $departamentoTable;
	protected $entradaprodutoTable;

    public function indexAction()
    {
	
		$cont = 0;
	
		$listaProdutos = $this->listaProdutos();
		
		var_dump($listaProdutos);
		
		foreach ($listaProdutos as $listaProduto) :
		
			echo "**************Produto $cont***************";
			echo "Nome do produto: ".$listaProduto->ds_produto;
			echo "Valor do produto: ".$listaProduto->vl_produto;
			echo "Latitude do produto: ".$listaProduto->latitude;
			echo "Longitude do produto: ".$listaProduto->longitude;
			echo "Nome da empresa: ".$listaProduto->nomefantasia;
			echo "********************FIM********************";
			
			$cont = $cont + 1;
		
		endforeach;
		
		exit(1);
	
        //return new ViewModel();
    }
	
	private function listaProdutos(){
	
		$ent_dados = new Entradaproduto();

		$row_ent = $this->getEntradaprodutoTable()->listar_produtos();
		
		return $row_ent;
	
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
