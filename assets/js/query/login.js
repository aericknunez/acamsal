$(document).ready(function()
{


	$('#btn-login').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/includes/process_login.php",
			method: "POST",
			data: $("#form-login").serialize(),
			beforeSend: function () {
				$('#btn-login').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-login').html('Ingresar').removeClass('disabled');	      
				$("#form-login").trigger("reset");
				$("#msj").html(data);	
			}
		})
	});
    



$("#form-login").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$('#btn-registrar').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=0",
			method: "POST",
			data: $("#form-registrar").serialize(),
			beforeSend: function () {
				$('#btn-registrar').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-registrar').html('Login').removeClass('disabled');	      
				$("#form-registrar").trigger("reset");
				$("#msj").html(data);	
			}
		})
	});
    



$("#form-registrar").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});













});