<?php
/**
 * funcao: Consulta nota fiscal eletronica
 * autor: Sebastiao Junio
 * Data: 29/01/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.quero.com.br)
 * 
 */

namespace Compracerta\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Zend\Http\Response;
use Zend\Json\Json as Jason;
use Zend\View\Model\JsonModel;


class HomeController extends AbstractActionController
{
    
    private $cookie="cookie.txt";
    
    public function indexAction(){
        
        $this->layout('layout/teste');
        
        $url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';
        
        $open = $this->open($url);

        $img = $this->getData($open, 'data:image/png;base64','"');
        
        $viewState = $this->getData($open, 'id="__VIEWSTATE" value=','"');
        
        $eventValidation = $this->getData($open, 'id="__EVENTVALIDATION" value=','"');
        
        $captchaSom = $this->getData($open, 'id="ContentPlaceHolder1_captchaSom"','"');
        
        $token = $this->getData($open, 'id="ContentPlaceHolder1_token"','"');
        
        return new ViewModel(
            
            array(
                'img' => $img[0], 
                'response'=>$open,
                'viewState'=>$viewState[1],
                'eventValidation'=>$eventValidation[1],
                'captchaSom'=>$captchaSom[1],
                'token'=>$token[1]
            )
        
        );
        
        /*$response = new \Zend\Http\Response();
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/xml; charset=utf-8');
        $response->setContent($open);
        return $response;*/
        
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
    
    private function getData($string, $start, $end)
    {
        $out    = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            
            return $string;
        }

        return '';
    }
    
    public function ajaxAction()
    {
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            
            $capth = htmlspecialchars($request->getPost('capctha'));
            //$url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8%3d';
            $url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';
            $chaveAcesso = $request->getPost('chave_acesso'); 
            $viewState = $request->getPost('viewState'); 
            $eventValidation = $request->getPost('eventValidation'); 
            $captchaSom = $request->getPost('captchaSom'); 
            $token = $request->getPost('token'); 
        
            $postdata = "__EVENTTARGET=&";
            $postdata = $postdata . "__EVENTARGUMENT=&";
            
            
            $postdata = $postdata . "__VIEWSTATE=".urlencode($viewState)."&";
            $postdata = $postdata . "__EVENTVALIDATION=".urlencode($eventValidation)."&";
            $postdata = $postdata . 'ctl00$txtPalavraChave=&';
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$txtChaveAcessoCompleta='.$chaveAcesso.'&';
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$txtCaptcha='.$capth.'&';
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$btnConsultar=Continuar&';
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$token='.$token.'&';
            //$postdata = $postdata . "ctl00\$ContentPlaceHolder1\$captchaSom=".$captchaSom."&";
            
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$captchaSom=ransitional%2F%2FEN';
            
            //$postdata = '__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=';
            
            //echo $postdata;
            
            $header[] = "Accept-Language:pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4";
            $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"; 
            $header[] = "Cache-Control: no-cache";
            
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
            
            $result = curl_exec($ch);
            $curl_info = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            
            $response = $this->getResponse();
            
            $response->setContent($result);
            
            //$headers = $response->getHeaders();
            //$headers->addHeaderLine('Content-Type', 'application/json');
        
            return $response;
            
        }
        
        $response = $this->getResponse();
        
        return $response;

    }
	
}