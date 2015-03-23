/**
 * funcao:Javascript Cadastro de produto
 * autor: Sebastiao Junio
 * Data: 13/03/2015
 *
 * @link      https://github.com/juniobc/Quero.git
 * @copyright Copyright (c) Quero (http://www.econoom.com.br)
 * 
 */
 
 google.load("visualization", "1", {packages:["table"]});
 
var stopTime;

$(document).ready( function () {
	
	$('#recarrega_img').click(function(){
		
		$(this).attr("style", "pointer-events: none");
		
		stopTime = setTimeout(
			
			function(){
	    		$('#myModal').modal({
				    backdrop: 'static',
				    keyboard: false
			})
				
		},2000)
		
		busca_captha();
		
	});
	
	$('#frm_busca_nf').submit(false);
    
    $('#consulta_nf').click(function(){
    	
    	$('#consulta_nf').attr("disabled", "true")
    	
    	stopTime = setTimeout(
			
			function(){
	    		$('#myModal').modal({
				    backdrop: 'static',
				    keyboard: false
			})
				
		},2000)
    	
    	
    	
    	$('#error_msg').hide();
    	$('#error_msg').html( "" );
    	
        consulta_nf();
        
    });
    
});

function drawTable(retorno) {
    var data = new google.visualization.DataTable();
    
    data.addColumn('string', 'Nome');
    data.addColumn('string', 'Unidade');
    data.addColumn('number', 'Valor Unitario');
    data.addColumn('number', 'Quantidade');
    data.addColumn('number', 'Valor total');
    
    $.each(retorno['produtos'],
			
		function(objeto){
			
			nome = retorno['produtos'][''+objeto+'']['nome'];
			unidade = retorno['produtos'][''+objeto+'']['unidade'];
			valor_total = parseFloat(retorno['produtos'][''+objeto+'']['valor'].replace(",","."));
			quantidade = parseFloat(retorno['produtos'][''+objeto+'']['quantidade'].replace(",","."));
			valor_un = valor_total/quantidade;
			
			valor_total = parseFloat(valor_total.toFixed(2));
			quantidade = parseFloat(quantidade.toFixed(2));
			valor_un = parseFloat(valor_un.toFixed(2));
			
			data.addRows([
		      [nome,unidade,valor_un,quantidade,valor_total]
		    ]);
			        
		}
			    
	);

    var table = new google.visualization.Table(document.getElementById('table_div'));

    table.draw(data, {showRowNumber: true, width:'100%'});
  }
  
function busca_captha(){
	
	$.post('cadastroproduto/cadastroproduto',{},
	function(retorno) {
		
		$("#viewState").val(retorno["viewState"]);
		$("#eventValidation").val(retorno["eventValidation"]);
		$("#captchaSom").val(retorno["captchaSom"]);
		$("#token").val(retorno["token"]);
		$("#img_captcha").attr("src","data:image/png;base64"+retorno['img']);
		
		clearTimeout(stopTime);
		$('#myModal').modal("hide");
		$('#error_msg').hide();
		$('#recarrega_img').attr("style", "pointer-events: visible");
		$('#captcha').val('');
		
	}, 'json'
	).error(function() {
		
		clearTimeout(stopTime);
		$('#myModal').modal("hide");
		$('#error_msg').html("");
		$('#error_msg').show();
	 	$('#error_msg').append( "<p>Erro ao buscar captcha tente novamente mais tarde !</p>" );
		
	});
	
	return false;
	
}


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
	 	
	 	if(retorno['ret'] == '1'){
	 		
	 		drawTable(retorno);
	 		busca_captha();
		
	 	}else{
	 		
	 		clearTimeout(stopTime);
			$('#myModal').modal("hide");
	 		$('#error_msg').show();
			$('#error_msg').html( "" );
		 	$('#error_msg').append( "<p>"+retorno['msg']+"</p>" );
	 		
	 	}
	 	
	 	$('#consulta_nf').removeAttr("disabled");
		
	}, 'json'
	).error(function() { 
		
		clearTimeout(stopTime);
		$('#myModal').modal("hide");
		$('#error_msg').show();
	 	$('#error_msg').append( "<p>Tente Novamente</p>" );
	 	
	 	$('#consulta_nf').removeAttr("disabled");
		
	});
	
	return false;
    
}