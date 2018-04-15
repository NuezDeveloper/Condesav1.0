$("#txtBuscar").on('keypress',function(e){
	if(e.keyCode==13){
		$.ajax({
			'url':'./php/agregarProdClave.php',
			'method':'POST',
			data:{
				mesa:'Alonso',
				id:$('#txtBuscar').val()
			}
		}).done(function(respuesta){
			//alert(respuesta);
			if(respuesta=='si')
				$("#txtBuscar").val("");
		});
	}//llave if
});//llave keypress
