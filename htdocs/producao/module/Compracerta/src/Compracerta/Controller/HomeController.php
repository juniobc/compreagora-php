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
        
        $request = $this->getRequest();
        
        $this->layout('layout/teste');
        
        $url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';
        
        $open = $this->open($url);

        $img = $this->getData($open, 'data:image/png;base64','"');
        
        $viewState = $this->getData($open, 'id="__VIEWSTATE" value=','"');
        
        $eventValidation = $this->getData($open, 'id="__EVENTVALIDATION" value=','"');
        
        $captchaSom = $this->getData($open, 'id="ContentPlaceHolder1_captchaSom"','"');
        
        $token = $this->getData($open, 'id="ContentPlaceHolder1_token"','"');
        
        if($request->isPost()){
            
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
            
        }else{
            
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
            
        }
        
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
    
    public function buscaNfeAction()
    {
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            
            $this->getServiceLocator()->get('Log')->info('capctha: '.$request->getPost('capctha'));
            $this->getServiceLocator()->get('Log')->info('chave_acesso: '.$request->getPost('chave_acesso'));
            $this->getServiceLocator()->get('Log')->info('viewState: '.$request->getPost('viewState'));
            $this->getServiceLocator()->get('Log')->info('eventValidation: '.$request->getPost('eventValidation'));
            $this->getServiceLocator()->get('Log')->info('token: '.$request->getPost('token'));
            
            $capth = strtoupper(htmlspecialchars($request->getPost('capctha')));
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
            $result = utf8_decode($result);
            
            $error = $this->getData(urldecode($result), '<legend class="titulo-aba">Dados da NF-e','</legend>');
            
            $cont = 1;
            $produtos = array();
            
            do{
                
                $produto = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>','</span>');
                
                if(!empty($produto)){
                    
                    $qt_prod = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>','</span>');
                    
                    $un_prod = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.$qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>','</span>');
                    
                    $vl_prod = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.$un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>','</span>');
                    
                    $cd_prod = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>','</span>');
                    
                    $nmc_prod = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>','</span>');
                    
                    $cd_tipi = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>','</span>');
                    
                    $cfop = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>','</span>');
                    
                    $desp = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>','</span>');
                    
                    $vl_desc = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>','</span>');
                    
                    $total_frete = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>'.
                    $vl_desc[0].'</span></td><td colspan="4"><label>Valor Total do Frete</label><span>','</span>');
                    
                    $vl_seguro = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>'.
                    $vl_desc[0].'</span></td><td colspan="4"><label>Valor Total do Frete</label><span>'.
                    $total_frete[0].'</span></td><td colspan="4"><label>Valor do Seguro</label><span>','</span>');
                    
                    $ind_compo = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>'.
                    $vl_desc[0].'</span></td><td colspan="4"><label>Valor Total do Frete</label><span>'.
                    $total_frete[0].'</span></td><td colspan="4"><label>Valor do Seguro</label><span>'.
                    $vl_seguro[0].'</span>','</span>');
                    
                    $percorre = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>'.
                    $vl_desc[0].'</span></td><td colspan="4"><label>Valor Total do Frete</label><span>'.
                    $total_frete[0].'</span></td><td colspan="4"><label>Valor do Seguro</label><span>'.
                    $vl_seguro[0].'</span>','<label>Valor do ICMS ST</label><span>');
                    
                    
                    
                    $icms = explode('</span>', $percorre[1]);
                    
                    
                    $cd_barra = $this->getData(urldecode($result), '<td class="fixo-prod-serv-numero"><span>'.
                    $cont.'</span></td><td class="fixo-prod-serv-descricao"><span>'.
                    $produto[0].'</span></td><td class="fixo-prod-serv-qtd"><span>'.
                    $qt_prod[0].'</span></td><td class="fixo-prod-serv-uc"><span>'.
                    $un_prod[0].'</span></td><td class="fixo-prod-serv-vb"><span>'.
                    $vl_prod[0].'</span></td></tr></table><table class="toggable box" style="background-color:#ECECEC">'.
                    '<tr><td><table class="box"><tr class="col-4"><td colspan="4"><label>C?digo do Produto</label><span>'.
                    $cd_prod[0].'</span></td><td colspan="4"><label>C?digo NCM</label><span>'.
                    $nmc_prod[0].'</span></td><td colspan="4"></td></tr><tr><td colspan="4"><label>C?digo EX da TIPI</label><span>'.
                    $cd_tipi[0].'</span></td><td colspan="4"><label>CFOP</label><span>'.
                    $cfop[0].'</span></td><td colspan="4"><label>Outras Despesas Acess?rias</label><span>'.
                    $desp[0].'</span></td></tr><tr><td colspan="4"><label>Valor do Desconto</label><span>'.
                    $vl_desc[0].'</span></td><td colspan="4"><label>Valor Total do Frete</label><span>'.
                    $total_frete[0].'</span></td><td colspan="4"><label>Valor do Seguro</label><span>'.
                    $vl_seguro[0].'</span>'.$ind_compo[0].'</span></td></tr><tr class="col-3"><td colspan="4"><label>C?digo EAN Comercial</label><span>', '</span>');
                    
                    
                    $produtos[$cont]['nome'] = $produto[0];
                    $produtos[$cont]['quantidade'] = $qt_prod[0];
                    $produtos[$cont]['unidade'] = $un_prod[0];
                    $produtos[$cont]['valor'] = $vl_prod[0];
                    $produtos[$cont]['cd_produto'] = $cd_prod[0];
                    $produtos[$cont]['cd_nmc'] = $nmc_prod[0];
                    $produtos[$cont]['vl_desc'] = $vl_desc[0];
                    $produtos[$cont]['cd_barra'] = $cd_barra[0];
                    $produtos[$cont]['icms'] = $icms[0];
                    $cont = $cont + 1;
                    
                }
                
            }while(!empty($produto));
            
            if(!empty($error)){
                
                $ret = 0;
                
                $razao_social = $this->getData(urldecode($result), '<td class="col-2"><label>Nome / Raz?o Social</label><span>','</span>');
                $nm_fantasia = $this->getData(urldecode($result), '<label>Nome Fantasia</label><span>','</span>');
                $dt_emis = $this->getData(urldecode($result), '<label>Data de Emiss?o</label><span>','</span>');
                $vl_total = $this->getData(urldecode($result), '<label>Valor Total da NFe</label><span>','</span>');

                $empresa = array(
            
                    'razao_social' => $razao_social[0],
                    'nm_fantasia' => $nm_fantasia[0]
                
                );
                
                $dt_emis = explode('/',$dt_emis[0]);
                
                $dados = array(
                    'ret' => $ret,
                    'empresa' => $empresa,
                    'vl_total' => $vl_total[0],
                    'dt_emis' => $dt_emis[2].$dt_emis[1].$dt_emis[0],
                    'produtos' => $produtos
                );                
                
            }else{
                
                 $ret = 1;
                 $msg = "Codigo incorreto   ";
                 
                 $dados = array(
                    'ret' => $ret,
                    'msg' => $msg
                );
                
            }
            
            $response = $this->getResponse();
            
            $response->setContent(json_encode($dados));
            //$response->setContent($result);
            
            $headers = $response->getHeaders();
            $headers->addHeaderLine('Content-Type', 'application/json');
        
            return $response;
            
        }
        
        $response = $this->getResponse();
        
        return $response;

    }
	
}