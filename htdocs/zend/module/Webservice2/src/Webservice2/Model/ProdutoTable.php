<?php 

namespace Webservice2\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ProdutoTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getProduto(Produto $produto)
     {
		
         $rowset = $this->tableGateway->select(array('ds_produto' => $produto->ds_produto));
         $row = $rowset->current();
		 
         return $row;
		 
     }

     public function saveProduto(Produto $Produto)
     {
		$data = array(
			'cd_catalogo' => $Produto->cd_catalogo,
			'vl_produto'  => $Produto->vl_produto,
			'ds_produto'  => $Produto->ds_produto,
		);

		$this->tableGateway->insert($data);
     }

     public function deleteProduto($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }