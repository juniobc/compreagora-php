<?php 

namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class EmpresaTable
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

     public function getEmpresa(Empresa $empresa)
     {
	 
		$rowset = $this->tableGateway->select(array('nomefantasia' => $empresa->nomefantasia));
		$row = $rowset->current();
		
		return $row;
     }

     public function saveEmpresa(Empresa $empresa)
     {
         $data = array(
             'cnpj' => $empresa->cnpj,
             'rasaosocial'  => $empresa->rasaosocial,
             'nomefantasia'  => $empresa->nomefantasia,
         );
		 
		$this->tableGateway->insert($data);
		
     }

     public function deleteEndereco($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }