<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Webservice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Produto;     
 
class CadastroProdutoController extends AbstractActionController{

	protected $produtoTable;

	public function indexAction(){
			
		//echo "teste";
		//exit(1);
		
        var_dump($this->getProdutoTable()->fetchAll());
		exit(1);
	
	}

	public function addAction(){
	
         $request = $this->getRequest();
         if ($request->isPost()) {
             $produto = new Produto();
             $form->setInputFilter($produto->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $produto->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveProduto($produto);
				
                 // Redirect to list of albums
                 echo "Inlcuido com sucesso";
             }
         }
	
	}

	public function editAction(){
	}

	public function deleteAction(){
	}
	
	public function getProdutoTable()
     {
         if (!$this->produtoTable) {
             $sm = $this->getServiceLocator();
             $this->produtoTable = $sm->get('Webservice\Model\ProdutoTable');
         }
         return $this->produtoTable;
     }
}
