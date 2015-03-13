<?php
/**
 * funcao: Pagina inicial do sistema
 * autor: Sebastiao Junio
 * Data: 25/02/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.econoom.com.br)
 * 
 */

namespace Compracerta\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json as Jason;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class AreatrabalhoController extends AbstractActionController{
    
    public function areatrabalhoAction(){
        
        $this->layout('layout/sistema');
        
    }

    
}