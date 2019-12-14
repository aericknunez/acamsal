$(document).ready(function(){



	
	$('#btn-addasociado').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=184",
			method: "POST",
			data: $("#form-addasociado").serialize(),
			beforeSend: function () {
				$('#btn-addasociado').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addasociado').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-addasociado").trigger("reset");
				$("#destinoasociado").html(data);	
			}
		})
	});



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

		$('#btn-unidades').attr("key",key);
		
	});



///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delasociado').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});




/// llamar modal unidades
	$("body").on("click","#btn-unidades",function(){ 
		
		$('#ModalVerAsociado').modal('hide');
		$('#ModalUnidades').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-unidades").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-unidades").html(data); // lo que regresa de la busquea 		
            }
        });

        $('#asociado').attr("value",key);

	});


	$('#btn-addunidad').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=196",
			method: "POST",
			data: $("#form-addunidad").serialize(),
			beforeSend: function () {
				$('#btn-addunidad').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addunidad').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-addunidad").trigger("reset");
				$("#vista-unidades").html(data);	
			}
		})
	});



	$("body").on("click","#delunidad",function(){ // borrar unidad
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	var asociado = $(this).attr('asociado');
	    $.post("application/src/routes.php", {op:op, hash:hash, asociado:asociado}, function(data){
		$("#vista-unidades").html(data);
	   	 });
	});



	$("body").on("click","#pagar",function(){ 
		
		$('#ModalPagar').modal('show');
		
		var hash = $(this).attr('hash');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&hash='+hash;

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

	});


	$("body").on("click","#cobrar",function(){ 
		var hash = $(this).attr('hash');
		var op = $(this).attr('op');
		var total = $(this).attr('total');
		var dataString = 'op='+op+'&hash='+hash+'&total='+total;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {  
            	$("#idcuota"+hash).html('CANCELADO');          
                $("#destino").html(data); // lo que regresa de la busquea 		
            }
        });

        $('#ModalPagar').modal('hide');
		

	});






}); // termina query