/**
 * funcao:Javascript Cadastro de produto
 * autor: Sebastiao Junio
 * Data: 13/03/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.econoom.com.br)
 * 
 */

$(document).ready( function () {
	
	$('#frm_busca_nf').submit(false);
    
    $('#consulta_nf').click(function(){
    	
    	$('#error_msg').hide();
    	$('#error_msg').html( "" );
    	
        consulta_nf();
        
    });
    
});

function consulta_nf(){
    
    $.post('cadastroproduto/buscanfe',{
		'capctha' : $('#captcha').val(),
		'chave_acesso' : $('#chave_acesso').val(),
		'viewState' : $('#viewState').val(),
		'eventValidation' : $('#eventValidation').val(),
		'captchaSom' : $('#captchaSom').val(),
		'token' : $('#token').val(),
	},
	function(retorno) {
		
		$('#error_msg').show();
	 	$('#error_msg').append( "<p>"+retorno['msg']+"</p>" );
		
	}, 'json'
	);/*.error(function() { 
		
		$('#error_msg').show();
	 	$('#error_msg').append( "<p>Tente Novamente</p>" );
		
	});*/
	
	return false;
    
}