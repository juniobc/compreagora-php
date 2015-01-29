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
use \Zend\Http\Response;


class HomeController extends AbstractActionController
{
    
    private $cookie="cookie.txt";
    
    public function indexAction(){
        
        $this->layout('layout/teste');
        
        $url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';
        
        $open = $this->open($url);

        $code = $this->between($open, 'data:image/png;base64','"');
        
        return new ViewModel(array('results' => $code));
        
        /*$response = new \Zend\Http\Response();
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/xml; charset=utf-8');
        $response->setContent($open);
        return $response;*/
        
    }



    
    private function open($url){
        
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL,$url); 
        curl_setopt($cURL, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
        curl_setopt($cURL, CURLOPT_HEADER, 0);
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
    
    private function between($string, $start, $end)
    {
        $out    = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            
            return $string[0];
        }

        return '';
    }
    
    /*$cookie="cookie.txt";
    function open($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt ($ch, CURLOPT_REFERER, $url);
        $result = curl_exec($ch);  
        curl_close($ch);

        return $result;
    }

    function between($string, $start, $end)
    {
        $out    = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            echo $string[0];
            return $string[0];
        }

        return '';
    }

    function get_captcha()
    {
        $url    = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';

        $open   = open($url);

        $code   = between($open, '<img src="https://academics.vit.ac.in/student/captcha.asp",>');



        return 'https://academics.vit.ac.in/student/captcha.asp' . $code;


    }


    function rahul()
    {
        $capth=htmlspecialchars($_POST['code']);

        echo $capth;

        $username="xyz"; 
        $password="abc"; 
        $url=""; 
        $cookie="cookie.txt";
        $veri=$capth;
    
        $com="Login";
    
        $postdata = "regno=".$username."&passwd=".$password."&vrfcd=".$veri."&submit=".$com;
    
        $ch = curl_init(); 
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
        curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
        curl_setopt ($ch, CURLOPT_REFERER, $url); 
    
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
        curl_setopt ($ch, CURLOPT_POST, 1); 
        $result = curl_exec ($ch); 
    
        echo $result;  
    
    
        $data = curl_exec($ch);

    }*/
	
}