$(document).ready(function()
{


	$('#btn-corte').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=115",
			method: "POST",
			data: $("#form-corte").serialize(),
			beforeSend: function () {
               $("#content").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$("#corte").html(data);
				$("#form-corte").trigger("reset");
			}
		})
	})
$("#form-corte").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});







    $("body").on("click","#ejecuta-corte",function(){
        var op = $(this).attr('op');
		var efectivo = $(this).attr('efectivo');
        var dataString = 'op='+op+'&efectivo='+efectivo;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
            $("#contenido").hide();
               $("#corte").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {  
            $("#contenido").show();          
                $("#corte").html(data); 
                $("#contenido").load('application/src/routes.php?op=117'); 
            }
        });
    });       





	$('#btn-cancelar').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=118",
			method: "POST",
			data: $("#form-cancelar").serialize(),
			beforeSend: function () {
               $("#content").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$("#corte").html(data);
				$("#form-cancelar").trigger("reset");
				window.location.href="?corte";
			}
		})
	})
$("#form-cancelar").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});








});