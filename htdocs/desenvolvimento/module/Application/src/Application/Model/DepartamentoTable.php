<?php 

namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class DepartamentoTable
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
         
        $sql = 'select * from empresa, departamento dpto where empresa.id_empresa = dpto.id_empresa
        and dpto.id_endereco = endereco.id_endereco';
		
		$linhas = $this->adapter->query($sql);
		
		$linhas = $linhas->execute();
		
		return $linhas;
     }
     
     public function buscaDptoLatLong(Endereco $endereco){
         
         $sql = '
         
         
            select dpto.*,  ((
            6371 *
            (	2 * 
            	atan2(
            		sqrt(
            			sin((radians('.$endereco->latitude.')-radians(latitude))/2) * sin((radians('.$endereco->latitude.')-radians(latitude))/2) + cos(radians(latitude)) * cos(radians('.$endereco->latitude.')) 
            			* sin((radians('.$endereco->longitude.')-radians(longitude))/2) * sin((radians('.$endereco->longitude.')-radians(longitude))/2)
            		),
            		sqrt(1-(
            			sin((radians('.$endereco->latitude.')-radians(latitude))/2) * sin((radians('.$endereco->latitude.')-radians(latitude))/2) + cos(radians(latitude)) * cos(radians('.$endereco->latitude.')) 
            			* sin((radians('.$endereco->longitude.')-radians(longitude))/2) * sin((radians('.$endereco->longitude.')-radians(longitude))/2)
            		))
            	)	
            )
            ) * 1000) as distancia 
            from departamento dpto, empresa, endereco 
            where dpto.id_empresa = empresa.id_empresa and dpto.id_endereco = endereco.id_endereco
         
         
         ';
		
		$linhas = $this->adapter->query($sql);
		
		$linhas = $linhas->execute();
		
		return $linhas;
         
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