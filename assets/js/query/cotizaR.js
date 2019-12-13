$(document).ready(function(){




    $("body").on("click","#borrar-ticket",function(){
        var op = $(this).attr('op');
		var hash = $(this).attr('hash');
        var dataString = 'op='+op+'&hash='+hash;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
            }
        });
    });                 



    $("body").on("click","#guardar",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
            }
        });
    });                 




    $("body").on("click","#select-orden",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=153'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
            }
        });
    });                 





///////////////////// para venta rapida

	$('#btn-busquedaR').click(function(e){ /// para el formulario
		e.preventDefault();
        if($('#cod').val() != ""){
    		$.ajax({
    			url: "application/src/routes.php?op=150",
    			method: "POST",
    			data: $("#form-busquedaR").serialize(),
    		// beforeSend: function(){
    		// 	$("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
      //           },
    		success: function(data){
    			$("#ver").html(data);
    			$("#form-busquedaR").trigger("reset");
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
    		}
    		});
        }
	})




    $("body").on("click","#modcant",function(){
        var op = $(this).attr('op');
		var cod = $(this).attr('cod');
        var dataString = 'op='+op+'&cod='+cod;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            // beforeSend: function () {
            //    $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            // },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=153'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
            }
        });
    });                 




/////buscar cliente
///
    $("#cliente-busqueda").keyup(function(){ /// para la caja de busqueda
        $.ajax({
        type: "POST",
        url: "application/src/routes.php?op=147",
        data:'keyword='+$(this).val(),
        beforeSend: function(){
            $("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
        },
        success: function(data){
            $("#muestra-busqueda").show();
            $("#muestra-busqueda").html(data);
            $("#cliente-busqueda").css("background","#FFF");
        }
        });
    });



    $("body").on("click","#select-c",function(){
    var hash = $(this).attr('hash');
    var nombre = $(this).attr('nombre');
        $.post("application/src/routes.php?op=148", {hash:hash, nombre:nombre}, 
        function(data){
            $("#muestra-busqueda").hide();
            $("#ver").html(data); // lo que regresa de la busquea 
            $("#c-busqueda").trigger("reset"); // no funciona
        });
    });


    $("body").on("click","#quitar-cliente",function(){ // quita descuento
        var op = $(this).attr('op');
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
            }
        });
    });   




//// buscar productos

    $("#producto-busqueda").keyup(function(){ /// para la caja de busqueda
        $.ajax({
        type: "POST",
        url: "application/src/routes.php?op=75",
        data:'keyword='+$(this).val(),
        beforeSend: function(){
            $("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
        },
        success: function(data){
            $("#muestra-busqueda").show();
            $("#muestra-busqueda").html(data);
            $("#producto-busqueda").css("background","#FFF");
        }
        });
    });



    $("body").on("click","#cancel-p",function(){
        $("#muestra-busqueda").hide();
        $("#p-busqueda").trigger("reset"); 
    });

////////////////



    $("body").on("click","#select-p",function(){
    var cod = $(this).attr('cod');
        $.post("application/src/routes.php?op=150", {cod:cod}, 
        function(data){
            $("#muestra-busqueda").hide();
            $("#ver").html(data); // lo que regresa de la busquea 
            $("#p-busqueda").trigger("reset"); // no funciona
            $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
        });
    });



//////////////cancelar
    $("body").on("click","#cancelar",function(){
        var op = $(this).attr('op');
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=146'); // caraga el lateral
            }
        });
    });   




$('#ModalBusqueda').on('shown.bs.modal', function() { // para autofocus en el modal
  $(this).find('[autofocus]').focus();
});












    $('#btn-Ccantidad').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=150",
            method: "POST",
            data: $("#form-Ccantidad").serialize(),
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data){
                $("#form-Ccantidad").trigger("reset");
                window.location.href="?cotizar"
            }
        })
    })




    $('#btn-descuento').click(function(e){ /// Aplicar descuento
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=155",
            method: "POST",
            data: $("#form-descuento").serialize(),
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data){
                $("#form-descuento").trigger("reset");
                 $("#ver").html(data); // lo que regresa de la busquea 
            }
        })
    })


    $("body").on("click","#quitar-descuento",function(){ // quita descuento
        var op = $(this).attr('op');
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
            }
        });
    });                 





/// llamar modal ver
    $("body").on("click","#xver",function(){ 
        
        $('#ModalVer').modal('show');
        
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

    });






    $('#imprimir').on("click", function () {
      $('#vista').printThis({
        importCSS: false,
        loadCSS: ["http://localhost/cozto/assets/css/font-awesome-582.css","http://localhost/cozto/assets/css/bootstrap.min.css", 
        "http://localhost/cozto/assets/css/mdb.min.css"],
        removeScripts: true,
         base: false
      });
    });




}); // termina query