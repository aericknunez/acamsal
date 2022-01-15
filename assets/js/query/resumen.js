$(document).ready(function()
{

    $("body").on("click","#paginar",function(){
        var op = $(this).attr('op');
        var orden = $(this).attr('orden');
        var campo = $(this).attr('dir');
        var dataString = 'op='+op+'&orden='+orden+'&campo='+campo;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
            }
        });
    });      


    function CargarDatos(campo, orden){
        var op = 350;
        var orden = orden;
        var campo = campo;
        var dataString = 'op='+op+'&orden='+orden+'&campo='+campo;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
            }
        });
    }


    CargarDatos('id', 'asc');
    


});