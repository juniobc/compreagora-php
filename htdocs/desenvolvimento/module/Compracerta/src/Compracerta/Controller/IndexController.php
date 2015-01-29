<?php
/**
 * funcao: Lista produtos cadastrados
 * autor: Sebastiao Junio
 * Data 07/10/2014
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.quero.com.br)
 * 
 */

namespace Compracerta\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\Json\Json as Jason;
use Zend\View\Model\JsonModel;


class IndexController extends AbstractActionController
{
    
    public function indexAction(){
        
    }
    
    public function ajaxAction(){
        
        $arrayProduto = array();
        $request = $this->getRequest();
        
        if($request->isPost()){
            
            if(is_numeric($request->getPost('nm_produto'))){
                
               return $this->procura_cd_barra();
                
            }else{
                
               return $this->listaproduto();
                
            }
            
        }else{
            
            return $this->redirect()->toRoute('compracerta');
            
        }
        
    }
    
    private function procura_cd_barra(){
        
        $arrayProduto = array();
        $request = $this->getRequest();
        
        $ListaProduto = $this->envia_rest('findOfferList', array('barcode'=>$request->getPost('nm_produto')));
        
        if(isset($ListaProduto['product']['productName']))
            $arrayProduto[1]['nm_produto'] = $ListaProduto['product']['productName'];
        if(isset($ListaProduto['product']['thumbnail']['@attributes']['url']))
            $arrayProduto[1]['img_produto'] = $ListaProduto['product']['thumbnail']['@attributes']['url'];
        if(isset($ListaProduto['product']['priceMin']) && isset($ListaProduto['product']['priceMin']))
            $arrayProduto[1]['preco_medio'] = number_format(
                ($ListaProduto['product']['priceMin'] + $ListaProduto['product']['priceMax'])/2, 2
            );
        
        $response = $this->getResponse();
        
        //$response->setContent(json_encode(array("teste"=>$request->getPost('nome'))));
        $response->setContent(json_encode($arrayProduto));
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        
        return $response;
        
    }
    
    private function envia_rest($tp_consulta, $paramentros){
        
        $arrayProduto = array();
        $request = $this->getRequest();
        
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');
        
        $client->setUri('http://sandbox.buscape.com/service/'.$tp_consulta.'/564771466d477a4458664d3d');
		
		$client->setMethod('GET');
        $client->setParameterGET($paramentros);  
        
        $response = $client->send();
        
        if (!$response->isSuccess()) {
                exit(1);
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
             
            $response = $this->getResponse();
            $response->setContent(json_encode($message));
            
            $headers = $response->getHeaders();
            $headers->addHeaderLine('Content-Type', 'application/json');
            
            return $response;
        }
        
        $body = $response->getBody();
         
        $response = $this->getResponse();
        $response->setContent($body);
        
        $simpleXML = simplexml_load_string($response->getBody());
        
        $jsonEncode = json_encode($simpleXML);
        $arrayProduto = json_decode($jsonEncode,TRUE);
        
        
        return $arrayProduto;
        
    }

	private function listaproduto(){
	    
	    $arrayProduto = array();
	    $cont = 1;
	    $request = $this->getRequest();
                
        $ListaProduto = $this->envia_rest('findProductList', 
        array('keyword'=>$request->getPost('nm_produto'), 'page' => $request->getPost('pagina')));
        
		if($ListaProduto['@attributes']['totalResultsAvailable'] > 0){
            
            foreach ($ListaProduto['product'] as $object) :
                
                if(isset($object['productName']))
                    $arrayProduto[$cont]['nm_produto'] = $object['productName'];
                if(isset($object['thumbnail']['@attributes']['url']))
                    $arrayProduto[$cont]['img_produto'] = $object['thumbnail']['@attributes']['url'];
                if(isset($object['priceMin']) && isset($object['priceMin']))
                    $arrayProduto[$cont]['preco_medio'] = number_format(($object['priceMin'] + $object['priceMax'])/2, 2);
                
                /*$productName = $object['productName'];
                $productShortName = $object['productShortName'];
                $currency = $object['currency'];
                $priceMin = $object['priceMin'];
                $priceMax = $object['priceMax'];
                $links = $object['links'];
                $thumbnail = $object['thumbnail'];
                $rating = $object['rating'];
                $specification = $object['specification']['item'];*/
                
                $cont = $cont + 1;
                
            endforeach;
            
            $arrayProduto['msg'] = 0;
            
            //var_dump($arrayProduto[0]);
            
            $response = $this->getResponse();
            //$response->setContent(json_encode(array("teste"=>$request->getPost('nome'))));
            $response->setContent(json_encode($arrayProduto));
            
            $headers = $response->getHeaders();
            $headers->addHeaderLine('Content-Type', 'application/json');
        
            return $response;
            
        }else{
            
            $arrayProduto['msg'] = 1;
            
            $response = $this->getResponse();
            
            $response->setContent(json_encode($arrayProduto));
            
            $headers = $response->getHeaders();
            $headers->addHeaderLine('Content-Type', 'application/json');
        
            return $response;
            
        }
        
        
		
	}
	
}
