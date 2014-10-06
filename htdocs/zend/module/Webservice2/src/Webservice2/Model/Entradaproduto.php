<?php

namespace Webservice2\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Entradaproduto implements InputFilterAwareInterface
 {
 
     public $id_dptoempresa;
     public $dt_ent;
     public $id_produto;

     public function exchangeArray($data)
     {
         $this->id_dptoempresa = (!empty($data['id_dptoempresa'])) ? $data['id_dptoempresa'] : 0;
         $this->dt_ent = (!empty($data['dt_ent'])) ? $data['dt_ent'] : null;
         $this->id_produto = (!empty($data['id_produto'])) ? $data['id_produto'] : 0;
     }
	 
	 public function setInputFilter(InputFilterInterface $inputFilter){
         throw new \Exception("Not used");
     }

     public function getInputFilter(){
     }

 }