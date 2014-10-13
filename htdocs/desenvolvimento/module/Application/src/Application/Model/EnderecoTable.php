<?php 

namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class EnderecoTable
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

     public function getEndereco(Endereco $endereco)
     {
	 
		$data = array(
             'latitude' => $endereco->latitude,
             'longitude'  => $endereco->longitude
         );
	 
         $rowset = $this->tableGateway->select($data);
         $row = $rowset->current();
		 
         return $row;
     }

     public function saveEndereco(Endereco $endereco)
     {
	 
		$data = array(
			'latitude' => $endereco->latitude,
			'longitude'  => $endereco->longitude,
		);
		 
		$this->tableGateway->insert($data);
		
     }

     public function deleteEndereco($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }