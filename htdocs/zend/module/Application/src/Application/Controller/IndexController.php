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
	
	public function indexAction(){
		
		//echo "teste1: ";
		//
		//$view = new ViewModel();
		//
		//echo "teste: ".$view->basePath();
		
		//exit(1);
		
	}

    public function listaProdutoAction()
    {
	
		$cont = 0;
	
		$listaProdutos = $this->listaProdutos();
		
		foreach ($listaProdutos as $listaProduto) :
			
			echo "**************Produto $cont***************</br>";
			echo "Nome do produto: ".$listaProduto["ds_produto"] . "</br>";
			echo "Valor do produto: ".$listaProduto["vl_produto"] . "</br>";
			echo "Latitude do produto: ".$listaProduto["latitude"] . "</br>";
			echo "Longitude do produto: ".$listaProduto["longitude"] . "</br>";
			echo "Nome da empresa: ".$listaProduto["descricao"] . "</br>";
			echo "</br>********************FIM********************</br></br>";
			
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

	private function getEntradaprodutoTable()
	{
		if (!$this->entradaprodutoTable) {
			$sm = $this->getServiceLocator();
			$this->entradaprodutoTable = $sm->get('Application\Model\EntradaprodutoTable');
		}
		return $this->entradaprodutoTable;
	}
}
