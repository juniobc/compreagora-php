<?php

namespace Webservice2\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Empresa implements InputFilterAwareInterface
 {
 
     public $id_empresa;
     public $cnpj;
     public $rasaosocial;
     public $nomefantasia;

     public function exchangeArray($data)
     {
         $this->id_empresa = (!empty($data['id_empresa'])) ? $data['id_empresa'] : 0;
         $this->cnpj  = (!empty($data['cnpj'])) ? $data['cnpj'] : null;
         $this->rasaosocial = (!empty($data['rasaosocial'])) ? strtoupper($data['rasaosocial']) : null;
         $this->nomefantasia = (!empty($data['nomefantasia'])) ? $data['nomefantasia'] : null;
     }
	 
	  public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         
     }

 }