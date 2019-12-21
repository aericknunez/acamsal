$(document).ready(function()
{


	
	$('#btn-sancion').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=220",
			method: "POST",
			data: $("#form-sancion").serialize(),
			beforeSend: function () {
				$('#btn-sancion').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-sancion').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-sancion").trigger("reset");
				$("#destinosancion").html(data);	
			}
		})
	});





	$("body").on("click","#delsancion",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinosancion").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delsancion').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});





	$('#btn-editsancion').click(function(e){ /// actualizar proveedor
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=222",
			method: "POST",
			data: $("#form-editsancion").serialize(),
			success: function(data){
				$("#form-editsancion").trigger("reset");
				$("#destinosancion").html(data);			
			}
		})
	})
    
















});