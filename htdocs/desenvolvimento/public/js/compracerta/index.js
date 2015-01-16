/**
 * Default Cadastro JavaScript
 * 
 * @author Sebastiao Junio
 * @version 2013/06/10
 */

$(document).ready( function () {

	$('#busca_produto').click(function(){
		campos = ['#nm_produto'];
		
		cadastrar();
			
	});

});


function cadastrar(){

	$.post('index/index',{
		'nome' : $('#nm_produto').val()
	},
	function(retorno) {
		if (retorno.ret == 0) {
			trataErros(retorno.msg);
		} else if(retorno.ret == 1){
			mostra_msg(1, retorno.msg);
		}else if(retorno.ret == 2){
			mostra_msg(2, retorno.msg);
		}
		
	}, 'json');
	return false;

}
