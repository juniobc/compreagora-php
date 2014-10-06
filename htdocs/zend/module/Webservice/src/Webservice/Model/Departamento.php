<?php

namespace Webservice\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Departamento implements InputFilterAwareInterface
 {
 
     public $id_dptoempresa;
     public $descricao;
     public $dt_cadstro;
     public $id_empresa;
     public $id_endereco;

     public function exchangeArray($data)
     {
         $this->id_dptoempresa     = (!empty($data['id_dptoempresa'])) ? $data['id_dptoempresa'] : 0;
         $this->descricao     = (!empty($data['descricao'])) ? strtoupper($data['descricao']) : null;
         $this->dt_cadstro = (!empty($data['dt_cadstro'])) ? $data['dt_cadstro'] : null;
         $this->id_empresa = (!empty($data['id_empresa'])) ? $data['id_empresa'] : null;
         $this->id_endereco = (!empty($data['id_endereco'])) ? $data['id_endereco'] : null;
     }
	 
	 public function setInputFilter(InputFilterInterface $inputFilter){
         throw new \Exception("Not used");
     }

     public function getInputFilter(){
     }

 }