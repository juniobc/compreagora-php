<?php

namespace Webservice\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Produto implements InputFilterAwareInterface
 {
     public $cd_catalogo;
     public $vl_produto;
     public $ds_produto;

     public function exchangeArray($data)
     {
         $this->cd_catalogo     = (!empty($data['cd_catalogo'])) ? $data['cd_catalogo'] : null;
         $this->vl_produto = (!empty($data['vl_produto'])) ? $data['vl_produto'] : null;
         $this->ds_produto  = (!empty($data['ds_produto'])) ? $data['ds_produto'] : null;
     }
	 
	  public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'cd_catalogo',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'vl_produto',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Float')
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'ds_produto',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }