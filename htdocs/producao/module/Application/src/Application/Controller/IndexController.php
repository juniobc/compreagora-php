<?php
/**
 * funcao: Lista produtos cadastrados
 * autor: Sebastiao Junio
 * Data 07/10/2014
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.quero.com.br)
 * 
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
		
		$dadosPagina = array(15);
		
		$listaProdutos = $this->listaProdutos();
		
		$cont = 1;
		
		foreach($listaProdutos as $produto) :
		
			$dadosPagina['titulo'.$cont] = $produto['ds_produto'];
			$dadosPagina['preco'.$cont] = $produto['vl_produto'];
			
			$cont = $cont + 1;
		
		endforeach;
		
		$listaProdutos = $this->listaProdutos();
		
		return new ViewModel(array(
             'listaProdutos' => $listaProdutos,
             'dadosPagina' => $dadosPagina
        ));
		
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
	
	
	 public function listaEmpresaAction()
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
	
}
