<?php 

namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class EntradaprodutoTable
 {
     protected $tableGateway;
     protected $adapter;

	public function __construct(TableGateway $tableGateway)
	{
	
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
		
	}

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }
	 
	public function listar_produtos(){
	
		
		$sql = 'select * from entradaproduto ent_prod
		inner join produto on ent_prod.id_produto = produto.id_produto
		inner join departamento dpto on ent_prod.id_dptoempresa = dpto.id_dptoempresa
		inner join endereco on dpto.id_endereco = endereco.id_endereco';
		
		$linhas = $this->adapter->query($sql);
		
		$linhas = $linhas->execute();
		
		return $linhas;
	
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