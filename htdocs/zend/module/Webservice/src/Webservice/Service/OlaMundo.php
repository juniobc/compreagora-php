<?php

namespace Webservice\Service;

class OlaMundo
{    
    /**
     * @return string
     */
    public function OlaMundo()
    {
        return "Ola Mundo";
    }
    
    /**
     * @return string
     */
    public function welcame($nome) {
	
		$adapter = $this->getServiceLocator()->get('Adapter');
		$connection = $adapter->getDriver()->getConnection();
		
		try{
		
			$connection->beginTransaction();
		
			$cd_catalogo = 0;
			$date = new \DateTime();
			$dt_ent_prod = $date->format('Y/m/d');
		
			$end_dados = new Endereco();
			$emp_dados = new Empresa();
			$dpto_dados = new Departamento();
			$prod_dados = new Produto();
			$ent_dados = new Entradaproduto();
			
			$end_dados->exchangeArray(array('latitude'=>$latitude, 'longitude'=>$longitude));
			
			$row_endr = $this->getEnderecoTable()->getEndereco($end_dados);
					
			if(!$row_endr){
			
				$this->getEnderecoTable()->saveEndereco($end_dados);
				$row_endr = $this->getEnderecoTable()->getEndereco($end_dados);
			
			}
			
			$emp_dados->exchangeArray(array(
				'cnpj'=>111111111111,
				'rasaosocial'=>$ds_empresa,
				'nomefantasia'=>$ds_empresa)
			);
			
			$row_emp = $this->getEmpresaTable()->getEmpresa($emp_dados);
			
			if(!$row_emp){
			
				$this->getEmpresaTable()->saveEmpresa($emp_dados);
				$row_emp = $this->getEmpresaTable()->getEmpresa($emp_dados);
			
			}
				
			$dpto_dados->exchangeArray(array(
				'descricao'=> $row_emp->nomefantasia,
				'dt_cadstro'=> $dt_ent_prod,
				'id_empresa'=> $row_emp->id_empresa,
				'id_endereco'=> $row_endr->id_endereco,
				)
			);
			
			$row_dpto = $this->getDepartamentoTable()->getDepartamento($dpto_dados);
			
			if(!$row_dpto){
			
				$this->getDepartamentoTable()->saveDepartamento($dpto_dados);
				$row_dpto = $this->getDepartamentoTable()->getDepartamento($dpto_dados);
			
			}
			
			$prod_dados->exchangeArray(array(
				'cd_catalogo'=> $cd_catalogo,
				'vl_produto'=> $vl_produto,
				'ds_produto'=> $ds_produto
				)
			);
			
			$row_prod = $this->getProdutoTable()->getProduto($prod_dados);
			
			if(!$row_prod){
			
				$this->getProdutoTable()->saveProduto($prod_dados);
				$row_prod = $this->getProdutoTable()->getProduto($prod_dados);
			
			}
			
			$ent_dados->exchangeArray(array(
				'id_dptoempresa'=> $row_dpto->id_dptoempresa,
				'id_produto'=> $row_prod->id_produto,
				'dt_ent'=> $dt_ent_prod
				)
			);
			
			$row_ent = $this->getEntradaprodutoTable()->getEntradaproduto($ent_dados);
			
			if(!$row_ent){
			
				$this->getEntradaprodutoTable()->saveEntradaproduto($ent_dados);
				$row_ent = $this->getEntradaprodutoTable()->getEntradaproduto($ent_dados);
			
			}
			
			$connection->commit();
			
			$msg = "Inclusão realizada com sucesso !";
		 
		}catch(\Exception $e){
		
			$connection->rollback();
			
			//$pgsqli = $adapter->getDriver()->getConnection()->getResource();        
			//$file = $e->getFile();
			//$line = $e->getLine();
			//var_dump($pgsqli);
			//echo "$file:$line ERRNO:$pgsqli->errno ERROR:$pgsqli->error";
			
			$msg = $e->getMessage();
		
		}
	
        return "Ola $nome, Seja bem vindo ao WebServer";
    }    
}