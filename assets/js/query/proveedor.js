$(document).ready(function(){

	$('#btn-addproveedor').click(function(e){ /// para el formulario
	$('#btn-addproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=60",
			method: "POST",
			data: $("#form-addproveedor").serialize(),
			success: function(data){
				$("#form-addproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-addproveedor').removeClass("disabled");
    }


	$("#form-addproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delproveedor",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoproveedor").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


////////////////
	$('#btn-editproveedor').click(function(e){ /// actualizar proveedor
	$('#btn-editproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=63",
			method: "POST",
			data: $("#form-editproveedor").serialize(),
			success: function(data){
				$("#form-editproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-editproveedor').removeClass("disabled");
    }


	$("#form-editproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});




/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerProveedor').modal('show');
		
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

		$('#btn-pro').attr("href",'?modal=editproveedor&key='+key);
		
	});






///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delproveedor').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});







}); // termina query