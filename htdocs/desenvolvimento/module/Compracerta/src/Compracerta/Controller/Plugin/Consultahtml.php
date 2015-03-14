<?php

namespace Compracerta\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Consultahtml extends AbstractPlugin{
    
    private $cookie="cookie.txt";
    
    public function conexaoCurl($url, $postdata = null){
        
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL,$url);
        if (!empty($postdata)){
            curl_setopt($cURL, CURLOPT_POST, true);
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $postdata);
        }
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
    
    public function percorre_html($string, $start, $end){
        
        $out    = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            
            return $string;
        }

        return '';
        
    }
    
    public function nf_error($html){
        
        $error = $this->percorre_html($html, 'tituloConteudoConsulta', '</li></ul>');
            
        $error = explode("<li>", $error[0]);
        
        return explode("</li>", $error[1]);
        
    }
    
}