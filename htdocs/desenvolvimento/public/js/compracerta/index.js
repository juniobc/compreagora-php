/**
 * Default Cadastro JavaScript
 * 
 * @author Sebastiao Junio
 * @version 2013/06/10
 */

$(document).ready( function () {
    
    $('#paginacao').click(function(event){
		
		//console.log($('#' + event.target.id).parent());
		if(event.target.id == 'pg_ant'){
		    
		}else if(event.target.id == 'pg_prox'){
		    
		}else{
		    
		    $('li[name=pg_li]').removeClass( "active" );
		    
		    $('#' + event.target.id).parent().addClass('active');
		    
		    listaproduto($('#' + event.target.id).text());
		    
		}
			    
	});
    
    
    $('#frm_busca_prod').submit(false);

	$('#busca_produto').click(function(){
		
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
		        
		    }
		    
		);
		
	}, 'json');
	
	return false;

}
