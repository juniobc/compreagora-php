<?php

namespace Webservice\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Produto implements InputFilterAwareInterface
 {
     public $id_produto;
     public $cd_catalogo;
     public $vl_produto;
     public $ds_produto;

     public function exchangeArray($data)
     {
         $this->id_produto = (!empty($data['id_produto'])) ? $data['id_produto'] : 0;
         $this->cd_catalogo = (!empty($data['cd_catalogo'])) ? $data['cd_catalogo'] : 0;
         $this->vl_produto = (!empty($data['vl_produto'])) ? $data['vl_produto'] : null;
         $this->ds_produto  = (!empty($data['ds_produto'])) ? $data['ds_produto'] : null;
     }
	 
	  public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
    
     }

 }