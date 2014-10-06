<?php 

namespace Webservice2\Model;

 use Zend\Db\TableGateway\TableGateway;

 class EntradaprodutoTable
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

     public function getEntradaproduto(Entradaproduto $ent_prod)
     {
		
		$data = array(
             'id_dptoempresa' => $ent_prod->id_dptoempresa,
             'id_produto'  => $ent_prod->id_produto,
			 'dt_ent' => $ent_prod->dt_ent
         );
	 
		$rowset = $this->tableGateway->select($data);
		$row = $rowset->current();
		
		return $row;
     }

     public function saveEntradaproduto(Entradaproduto $ent_prod)
     {
	 
         $data = array(
             'id_dptoempresa' => $ent_prod->id_dptoempresa,
             'id_produto'  => $ent_prod->id_produto,
             'dt_ent'  => $ent_prod->dt_ent,
         );
		 
		$this->tableGateway->insert($data);
		
     }

     public function deleteEndereco($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }