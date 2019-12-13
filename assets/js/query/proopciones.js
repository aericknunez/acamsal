$(document).ready(function(){

/// categorias
	$('#btn-addcategoria').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=22",
			method: "POST",
			data: $("#form-addcategoria").serialize(),
			success: function(data){
				$("#form-addcategoria").trigger("reset");
				$("#destinocategoria").html(data);			
			}
		})
	})
    

	$("#form-addcategoria").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



/// Unidades de medida
	$('#btn-addunidad').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=24",
			method: "POST",
			data: $("#form-addunidad").serialize(),
			success: function(data){
				$("#form-addunidad").trigger("reset");
				$("#destinounidad").html(data);			
			}
		})
	})
    

	$("#form-addunidad").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});






/// Caracteristicas
	$('#btn-addcarateristica').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=26",
			method: "POST",
			data: $("#form-addcarateristica").serialize(),
			success: function(data){
				$("#form-addcarateristica").trigger("reset");
				$("#destinocaracteristica").html(data);			
			}
		})
	})
    

	$("#form-addcarateristica").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	




/// ubicacion
	$('#btn-addubicacion').click(function(e){ /// para agregar ubicacion
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=28",
			method: "POST",
			data: $("#form-addubicacion").serialize(),
			success: function(data){
				$("#form-addubicacion").trigger("reset");
				$("#destinoubicacion").html(data);			
			}
		})
	})
    

	$("#form-addubicacion").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});








///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		var valor = $(this).attr('valor');

		
		$('#btn-modal').attr("valor",valor).attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});
    



	$("body").on("click","#btn-modal",function(){ // borrar el elemento
	var op = $(this).attr('op');
	var valor = $(this).attr('valor');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
	    	
	    	if(valor == '1'){ $("#destinocategoria").html(data); }
	    	if(valor == '2'){ $("#destinounidad").html(data); }
	    	if(valor == '3'){ $("#destinocaracteristica").html(data); }
	    	if(valor == '4'){ $("#destinoubicacion").html(data); }
		
			$('#ConfirmDelete').modal('hide');
	   	 });
	});







}); // termina query