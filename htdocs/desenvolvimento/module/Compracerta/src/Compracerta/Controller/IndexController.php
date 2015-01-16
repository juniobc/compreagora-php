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

class IndexController extends AbstractActionController
{
    
    public function indexAction(){
        
        var_dump($this->getRequest()->isPost());
        
        if($this->getRequest()->isPost()){
            
            echo "teste: ". $this->params()->fromPost('nome');
            exit(1);
            
        }else{
            
            echo "teste2: ";
            
        }
    }

	public function listaproduto(){
	    
	    
	        
		$client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');
        
        $client->setUri('http://sandbox.buscape.com/service/findProductList/6c71682f5a3250676359383d');
		
		$client->setMethod('GET');
        $client->setParameterGET(array('keyword'=>$this->params()->fromPost('nome'), 'page' => 10));  
        
        $response = $client->send();
        
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
             
            $response = $this->getResponse();
            $response->setContent($message);
            return $response;
        }
        
        $body = $response->getBody();
         
        $response = $this->getResponse();
        $response->setContent($body);
        
        $simpleXML = simplexml_load_string($response->getBody());
        
        $jsonEncode = json_encode($simpleXML);
        $ListaProduto = json_decode($jsonEncode,TRUE);
        
        return new ViewModel(array("objects" => $ListaProduto['product']));
        
        /*var_dump(array_keys($ListaProduto['product']));
            
        echo '</br>************************************************</br>';
        echo '</br>';
        
        var_dump($ListaProduto['@attributes']);
            
        echo '</br>************************************************</br>';
        echo '</br>';
        
        $cont = 0;
        
        foreach ($ListaProduto['product'] as $object) :
            
            var_dump(array_keys($object));
            
            echo '</br>*********************Analise obj '.$cont.'***************************</br>';
            
            $productName = $object['productName'];
            $productShortName = $object['productShortName'];
            $currency = $object['currency'];
            $priceMin = $object['priceMin'];
            $priceMax = $object['priceMax'];
            $links = $object['links'];
            $thumbnail = $object['thumbnail'];
            $rating = $object['rating'];
            $specification = $object['specification']['item'];
            
            echo 'Nome do produto: '.$productName.'</br>Thumbnail:</br>';
            
            foreach ($thumbnail as $chave) :
                
                if(isset($chave['url'])){
                    
                    echo 'teste';
                    
                }
            
            endforeach;
            
            echo '</br>*********************Fim***************************</br>';
            
            $cont = $cont + 1;
            
        endforeach;*/
		
	}
	
	public function listacategoriaAction(){
	    
	     
		$client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');
        
        $client->setUri('http://sandbox.buscape.com/service/findProductList/lomadee/6c71682f5a3250676359383d');
		
		$client->setMethod('GET');
        $client->setParameterGET(array('keyword'=>'caneta'));  
        
        $response = $client->send();
        
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
             
            $response = $this->getResponse();
            $response->setContent($message);
            return $response;
        }
        $body = $response->getBody();
         
        $response = $this->getResponse();
        $response->setContent($body);
        
        $jason = new Jason();
        
        $jsonContents = $jason->fromXml($response->getBody(), true);
        
        $jasonDecode = json_decode($jsonContents, true);
        
        var_dump(array_keys($jasonDecode['Result']));
            
        echo '</br>************************************************</br>';
        echo '</br>';
        
        foreach ($jasonDecode['Result']['product'] as $object) :
            
            $productName = $object['productName'];
            $productShortName = $object['productShortName'];
            $currency = $object['currency'];
            $priceMin = $object['priceMin'];
            $priceMax = $object['priceMax'];
            $links = $object['links'];
            $thumbnail = $object['thumbnail'];
            $rating = $object['rating'];
            $specification = $object['specification']['item'];
        
            
            var_dump(array_keys($object));
            echo '</br></br>Nome do produto: ' . $productName;
            echo '</br>Nome do apelido: ' . $productShortName . '</br>';
            echo '</br>Nome do currency: ' . $currency . '</br>';
            echo '</br>Preço minimo: ' . $priceMin . '</br>';
            echo '</br>Preço maximo: ' . $priceMax . '</br>Links: ';
            echo '</br> ' . var_dump($links) . '</br>Thunbail: ';
            echo '</br> ' . var_dump($thumbnail) . '</br>Rating: ';
            echo '</br> ' . var_dump($rating) . '</br>Especificação:</br>';
            echo '</br>' .var_dump(array_keys($specification)) . '</br>';
            foreach ($specification as $chave => $valor) :
            
                echo '</br>'.var_dump($valor).'</br>';
            
            endforeach;
            echo '</br>************************************************</br>';
            echo '</br>';
            
        
        endforeach;
	
		
	}
	
}
