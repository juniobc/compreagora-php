/**
 * Default Cadastro JavaScript
 * 
 * @author Sebastiao Junio
 * @version 2013/06/10
 */

$(document).ready( function () {
    
    
    $('#frm_busca_prod').submit(false);

	$('#busca_produto').click(function(){
		
		$('#busca_produto').attr('disabled', 'disabled');
		
		listaproduto(1);
		
	});
	

});


function listaproduto(pagina){
	
  	$.post('ajax',{
		'nm_produto' : $('#nm_produto').val(),
		'pagina' : pagina
	},
	function(retorno) {
		
	    $("div[id^='thumbnail']").css("display", "none");
		
		$.each(retorno,
		
		    function(objeto){
		        $("#thumbnail"+objeto).css("display", "block");
        		$("#img"+objeto).attr("src",retorno[objeto]['img_produto']);
        		$("#titulo"+objeto).text(retorno[objeto]['nm_produto']);
        		$("#preco"+objeto).text(retorno[objeto]['preco_medio']);
        		
        		$('#busca_produto')
		        
		    }
		    
		);
		
	}, 'json');
	
	return false;

}
