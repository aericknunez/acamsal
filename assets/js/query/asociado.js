$(document).ready(function(){

	$('#btn-addasociado').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=184",
			method: "POST",
			data: $("#form-addasociado").serialize(),
			success: function(data){
				$("#form-addasociado").trigger("reset");
				$("#destinoasociado").html(data);			

			}
		})
	})
    


	$("#form-addasociado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delasociado",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoasociado").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


////////////////
	$('#btn-editasociado').click(function(e){ /// actualizar proveedor
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=187",
			method: "POST",
			data: $("#form-editasociado").serialize(),
			success: function(data){
				$("#form-editasociado").trigger("reset");
				$("#destinoasociado").html(data);			
			}
		})
	})
    



	$("#form-editasociado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerAsociado').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#btn-pro').attr("href",'?modal=editasociado&key='+key);
		
	});



///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delasociado').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});












}); // termina query