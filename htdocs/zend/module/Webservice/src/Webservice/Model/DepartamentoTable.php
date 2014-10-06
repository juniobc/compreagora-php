<?php 

namespace Webservice\Model;

 use Zend\Db\TableGateway\TableGateway;

 class DepartamentoTable
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

     public function getDepartamento(Departamento $departamento)
     {
		
		$departamento->id_empresa = (int) $departamento->id_empresa;
	 
		$rowset = $this->tableGateway->select(array('id_empresa' => $departamento->id_empresa));
		$row = $rowset->current();
		
		return $row;
     }

     public function saveDepartamento(Departamento $departamento)
     {
         $data = array(
             'descricao' => $departamento->descricao,
             'dt_cadstro'  => $departamento->dt_cadstro,
             'id_empresa'  => $departamento->id_empresa,
             'id_endereco'  => $departamento->id_endereco,
         );
		 
		$this->tableGateway->insert($data);
		
     }

     public function deleteEndereco($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }