<?php

namespace Webservice\Service;

use Zend\Db\TableGateway\TableGateway;

class produto
{    
    /**
     * @return string
     */
	 
	public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }
	
    public function OlaMundo()
    {
        return "Olá Mundo";
		
		
		$adapter->query('ALTER TABLE ADD INDEX(`foo_index`) ON (`foo_column`)', Adapter::QUERY_MODE_EXECUTE);
    }
    
    /**
     * @return string
     */
    public function welcame($nome) {
        return "Ola $nome, Seja bem vindo ao WebServer";
    }  

		$sql = "SHOW COLUMNS FROM Mytable LIKE 'Mycolumn'"; 

$statement = $this->adapter->query($sql); 
return $statement->execute(); 
}