$(document).ready(function()
{

///////////// llamar modal para ver gasto
    $("body").on("click","#xver",function(){ 
        
        $('#ModalImg').modal('show');
        var iden = $(this).attr('iden'); 
        CargaImagen(iden);
    });

    
    function CargaImagen(iden){ // Extrae los datos del perfil cuando es invocada la funcion
            $.ajax({
                url: "application/src/routes.php?op=175&gasto="+iden,
                method: "POST",
                success: function(data){
                    $("#vista").html(data);         
                }
            });
    }


    $("body").on("click","#verimagen",function(){ 
         var iden = $(this).attr('iden');
          var gasto = $(this).attr('gasto');
         $.ajax({
                url: "application/src/routes.php?op=176&iden="+iden+"&gasto="+gasto,
                method: "POST",
                success: function(data){
                    $("#vista").html(data);         
                }
            });
    });







});