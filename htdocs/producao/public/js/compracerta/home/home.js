/**
 * Default Cadastro JavaScript
 * 
 * @author Sebastiao Junio
 * @version 2013/06/10
 */

$(document).ready( function () {
    
    $('#frm_consultar').submit(false);

	$('#consultar').click(function(){
		
		//$('#consultar').prop('disabled',true);
		
		consultaNfe();
		
	});

});


function consultaNfe(){
	
  	$.post('buscanfe',{
		'capctha' : $('#captcha').val(),
		'chave_acesso' : $('#chave_acesso').val(),
		'viewState' : $('#viewState').val(),
		'eventValidation' : $('#eventValidation').val(),
		'captchaSom' : $('#captchaSom').val(),
		'token' : $('#token').val(),
	},
	function(retorno) {
		
		//$('#consultar').prop('disabled', false);
		
		$('#resultado').html(retorno);
		
	}, 'json');
	
	return false;

}
