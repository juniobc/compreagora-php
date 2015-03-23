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
        
        $error = $this->percorre_html($html, 'listaErro', '</li>');
            
        //$error = explode("<li>", $error[0]);
        
        //$error = explode("</li>", $error[1]);
        
        return $error;
        
    }
    
    public function busca_produtos($html){
        
        $cont = 1;
        $produtos = array();
        
        do{
                
                $produto = $this->percorre_html($html, '<td class="fixo-prod-serv-numero"><span>'.
                $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>','</span>');
                
                if(!empty($produto)){
                    
                    $nm_produto = $produto[0];
                    
                    $qt_produto = $produto[1];
                    
                    $un_produto = $produto[2];
                    
                    $vl_total_produto = $produto[3];
                    
                    $produtos[$cont]['nome'] = $nm_produto;
                    $produtos[$cont]['quantidade'] = explode('</td><td class="fixo-prod-serv-qtd"><span>',$qt_produto)[1];
                    $produtos[$cont]['unidade'] = explode('</td><td class="fixo-prod-serv-uc"><span>', $un_produto)[1];
                    $produtos[$cont]['valor'] = explode('</td><td class="fixo-prod-serv-vb"><span>' ,$vl_total_produto)[1];
                    
                    //$produtos[$cont]['cd_barra'] = $cd_barra[0];
                    
                    $cont = $cont + 1;
                    
                }
                
        }while(!empty($produto));
        
        return $produtos;
        
    }
    
    public function busca_empresa($conexao){
        
        $razao_social = $this->percorre_html(utf8_decode(urldecode($conexao)), '<td class="col-2"><label>Nome / Raz?o Social</label><span>', '</span>');
        $nm_fantasia = $this->percorre_html(utf8_decode(urldecode($conexao)), '<label>Nome Fantasia</label><span>','</span>');
        
        $empresa = array(
            
            'razao_social' => $razao_social[0],
            'nm_fantasia' => $nm_fantasia[0]
        
        );
        
        return $empresa;
        
    }
    
    public function busca_nf($conexao){
        
        $dt_emis = $this->percorre_html(utf8_decode(urldecode($conexao)), '<label>Data de Emiss?o</label><span>','</span>');
        $vl_total = $this->percorre_html(utf8_decode(urldecode($conexao)), '<label>Valor Total da NFe</label><span>','</span>');
        
        $nota_fiscal = array(
            
            'dt_emis' => $dt_emis[0],
            'vl_total' => $vl_total[0]
        
        );
        
        return $nota_fiscal;
        
    }
    
}