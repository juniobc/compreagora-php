<?php 

namespace Webservice\Model;

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

     public function getProduto($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id_produto' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Não foi possivel encontrar o produto $id !");
         }
         return $row;
     }

     public function saveProduto(Produto $Produto)
     {
         $data = array(
             'cd_catalogo' => $album->artist,
             'vl_produto'  => $album->vl_produto,
             'ds_produto'  => $album->ds_produto,
         );

         $id = (int) $album->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id_produto' => $id));
             } else {
                 throw new \Exception('Produto não existe !');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id_produto' => (int) $id));
     }
 }