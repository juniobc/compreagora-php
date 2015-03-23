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
    
    public function cadastroprodutoAction(){
        
        $this->layout('layout/sistema');
        
        $url = 'http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=';
        
        $conexao = $this->Consultahtml()->conexaoCurl($url);

        $img = $this->Consultahtml()->percorre_html($conexao, 'data:image/png;base64','"');
        
        $viewState = $this->Consultahtml()->percorre_html($conexao, 'id="__VIEWSTATE" value=','"');
        
        $eventValidation = $this->Consultahtml()->percorre_html($conexao, 'id="__EVENTVALIDATION" value=','"');
        
        $captchaSom = $this->Consultahtml()->percorre_html($conexao, 'id="ContentPlaceHolder1_captchaSom"','"');
        
        $token = $this->Consultahtml()->percorre_html($conexao, 'id="ContentPlaceHolder1_token"','"');
        
        $dados = array(
            'img' => $img[0],
            'viewState'=>$viewState[1],
            'eventValidation'=>$eventValidation[1],
            'captchaSom'=>$captchaSom[1],
            'token'=>$token[1]
        );
        
        if(!$this->getRequest()->isPost()){
            
            return new ViewModel($dados);
            
        }else{
            
            return $this->envia_json($dados);
            
        }
        
        
    }
    
    public function buscaNfeAction(){
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            
            if(empty($request->getPost('chave_acesso'))){
                $ret = 0;
            
                $dados = array(
                    'ret' => $ret,
                    'msg' => 'Informe o número da nota fiscal!'
                );
                
                return $this->envia_json($dados);
                
            }
            
            if(empty($request->getPost('capctha'))){
                
                $ret = 0;
            
                $dados = array(
                    'ret' => $ret,
                    'msg' => 'Informe o código da imagem!'
                );
                
                return $this->envia_json($dados);
                
            }
            
            $capth = strtoupper(htmlspecialchars($request->getPost('capctha')));
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
            $postdata = $postdata . 'ctl00$ContentPlaceHolder1$captchaSom=ransitional%2F%2FEN';
            
            $conexao = $this->Consultahtml()->conexaoCurl($url, $postdata);
            
            if(!empty($this->Consultahtml()->nf_error($conexao))){
                
                $ret = 0;
            
                $dados = array(
                    'ret' => $ret,
                    'msg' => 'Código da imagem incorreto!'
                );
                
                return $this->envia_json($dados);
                
            }
            
            $ret = 1;
            
            $this->getServiceLocator()->get('texto')->info('Resposta Curl: '.$conexao);
            $this->getServiceLocator()->get('texto')->info("=================================================================================");
            $this->getServiceLocator()->get('texto')->info("=================================================================================");
            $this->getServiceLocator()->get('texto')->info("=================================================================================");
            $this->getServiceLocator()->get('texto')->info("=================================================================================");
            $this->getServiceLocator()->get('texto')->info("=================================================================================");
            
            $produtos = $this->Consultahtml()->busca_produtos($conexao);
            
            $empresa = $this->Consultahtml()->busca_empresa($conexao);
            
            $nota_fiscal = $this->Consultahtml()->busca_nf($conexao);
            
            //$this->getServiceLocator()->get('texto')->info('Data: '.$nota_fiscal['dt_emis']);
            
            $dados = array(
                
                'ret' => $ret,
                'empresa' => $empresa,
                'nota_fiscal' => $nota_fiscal,
                'produtos' => $produtos
            
            );
            
            return $this->envia_json($dados);
            
        }
        
        $response = $this->getResponse();
        
        return $response;

    }
    
    private function envia_json($dados){
        
        $response = $this->getResponse();
            
        $response->setContent(json_encode($dados));
        //$response->setContent($result);
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
    
        return $response;
        
    }

    
}