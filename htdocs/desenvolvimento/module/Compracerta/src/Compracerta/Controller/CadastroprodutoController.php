<?php
/**
 * funcao: Cadastro de Nota Fiscal
 * autor: Sebastiao Junio
 * Data: 12/03/2015
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


class CadastroprodutoController extends AbstractActionController{
    
    public function indexAction(){
        
        $this->layout('layout/sistema');
        
        $request = $this->getRequest();
        
        $open = $this->open($url);

        $img = $this->getData($open, 'data:image/png;base64','"');
        
        $viewState = $this->getData($open, 'id="__VIEWSTATE" value=','"');
        
        $eventValidation = $this->getData($open, 'id="__EVENTVALIDATION" value=','"');
        
        $captchaSom = $this->getData($open, 'id="ContentPlaceHolder1_captchaSom"','"');
        
        $token = $this->getData($open, 'id="ContentPlaceHolder1_token"','"');
            
        $result = array(
            
            'img' => $img[0], 
            'viewState'=>$viewState[1],
            'eventValidation'=>$eventValidation[1],
            'captchaSom'=>$captchaSom[1],
            'token'=>$token[1]
            
        );
        
        $data = array(
            'ret' => 0,
            'dados' => $result
        );
        
        $response = $this->getResponse();
        
        $response->setContent(json_encode($data));
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
    
        return $response;
        
        
    }
    
    private function open($url){
        
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL,$url); 
        curl_setopt($cURL, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
        curl_setopt($cURL, CURLOPT_HEADER, 1);
        curl_setopt($cURL, CURLOPT_COOKIE, 1);
        curl_setopt($cURL, CURLOPT_COOKIEJAR,$this->cookie);
        curl_setopt($cURL, CURLOPT_COOKIEFILE,$this->cookie);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt ($cURL, CURLOPT_REFERER, $url);

        $resultado = curl_exec($cURL);

        curl_close($cURL);
        
        return $resultado;
        
    }
    
    private function getData($string, $start, $end){
        
        $out    = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            
            return $string;
        }

        return '';
    }

    
}