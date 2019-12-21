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


	
	$('#btn-addconductor').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=210",
			method: "POST",
			data: $("#form-addconductor").serialize(),
			beforeSend: function () {
				$('#btn-addconductor').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addconductor').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				//$("#form-addconductor").trigger("reset");
				$("#destinoconductor").html(data);	
			}
		})
	});



	$('#btn-modconductor').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=211",
			method: "POST",
			data: $("#form-modconductor").serialize(),
			beforeSend: function () {
				$('#btn-modconductor').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-modconductor').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				//$("#form-addconductor").trigger("reset");
				$("#destinoconductor").html(data);	
			}
		})
	});
    



	$("body").on("click","#delconductor",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoconductor").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delconductor').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});





/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerConductor').modal('show');
		
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

		$('#btn-pro').attr("href",'?modal=editconductor&key='+key);

		$('#xfoto').attr("key",key);
		
	});





/// llamar modal ver
	$("body").on("click","#xfoto",function(){ 
		
		$('#ModalVerConductor').modal('hide');
		$('#ModalFotoConductor').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-foto").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-foto").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#iden-foto').attr("value",key);
		
	});




    $("#btn-foto").click(function (event) {
        event.preventDefault();
        var form = $('#form-foto')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "application/src/routes.php?op=216",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function () {
                $('#btn-foto').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function (data) {
                $('#btn-foto').html('Subir Imagen').removeClass('disabled');
                $("#vista-foto").html(data);
                $("#form-foto").trigger("reset");
            },
        });
    });








});