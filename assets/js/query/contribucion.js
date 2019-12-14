$(document).ready(function()
{

		$('.datepicker').pickadate({
		  weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		  weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
		  'Noviembre', 'Diciembre'],
		  monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
		  'Nov', 'Dic'],
		  showMonthsShort: true,
		  formatSubmit: 'dd-mm-yyyy',
		  close: 'Cancel'
		})


	
	$('#btn-contribucion').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=190",
			method: "POST",
			data: $("#form-contribucion").serialize(),
			beforeSend: function () {
				$('#btn-contribucion').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-contribucion').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-contribucion").trigger("reset");
				$("#destinocontribucion").html(data);	
			}
		})
	});



	$('#btn-editcontribucion').click(function(e){ /// actualizar proveedor
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=192",
			method: "POST",
			data: $("#form-editcontribucion").serialize(),
			success: function(data){
				$("#form-editcontribucion").trigger("reset");
				$("#destinocontribucion").html(data);			
			}
		})
	})
    



	$("body").on("click","#delcontribucion",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinocontribucion").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delcontribucion').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});














});