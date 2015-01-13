<?php

namespace Webservice\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Endereco implements InputFilterAwareInterface
 {
 
     public $id_endereco;
     public $latitude;
     public $longitude;

     public function exchangeArray($data)
     {
         $this->id_endereco     = (!empty($data['id_endereco'])) ? $data['id_endereco'] : 0;
         $this->latitude     = (!empty($data['latitude'])) ? $data['latitude'] : null;
         $this->longitude = (!empty($data['longitude'])) ? $data['longitude'] : null;
     }
	 
	  public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         
     }

 }