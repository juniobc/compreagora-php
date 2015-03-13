/**
 * funcao:Javascript Home
 * autor: Sebastiao Junio
 * Data: 25/02/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.econoom.com.br)
 * 
 */

$(document).ready( function () {
    
    $('#error_msg').hide();
    
    $('#frm_login').submit(false);

	$('#login').click(function(){
	    
	    $('#error_msg').hide();
		
		//$('#consultar').prop('disabled',true);
		
		login();
		
	});
	
	$('#myModal').on('hidden.bs.modal', function () {
		$('#error_msg').html('');
		$('#error_msg').hide();
	})
	
});

function login(){
	
  	$.post('authenticate',{
		'username' : $('#username').val(),
		'password' : $('#password').val(),
		'rememberme':$('#rememberme').val()
	},
	function(retorno) {
		
		if(retorno['errors'].length > 0){
		    $('#error_msg').html('');
		    
		    $('#error_msg').show();
		    
		    $.each(retorno['errors'], function(index) {
		    	
	            $('#error_msg').append( "<p>"+retorno['errors'][index]+"</p>" );
	         
	        });
		}else{
			
			window.location = retorno['redirect'];
			
		}
        
        
	    
	    //alert(retorno);
		
		//$('#consultar').prop('disabled', false);
		
		//$('#resultado').html(retorno);
		
	}, 'json');
	
	return false;

}
