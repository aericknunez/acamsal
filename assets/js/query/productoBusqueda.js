$(document).ready(function(){

// busqueda actualizar
	$("#key").keyup(function(){ /// para la caja de busqueda
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
			$("#key").css("background","#FFF");
		}
		});
	});



    $('#btn-busqueda').click(function(e){ /// para que funcione la busqueda al dar enter
    e.preventDefault();
    $.ajax({
            url: "application/src/routes.php?op=58",
            method: "POST",
            data: $("#p-busqueda").serialize(),
            success: function(data){ 
                $("#muestra-busqueda").hide();
                $("#contenido").html(data); // lo que regresa de la busquea 
                $("#p-busqueda").trigger("reset");
            }
        })
    });




//////// cancel 
	$("body").on("click","#cancel-p",function(){
		$("#muestra-busqueda").hide();
		$("#p-busqueda").trigger("reset"); 
	});

////////////////

	$("body").on("click","#select-p",function(){
	var key = $(this).attr('cod');
    	$.post("application/src/routes.php?op=58", {key:key}, 
    	function(data){
    		$("#muestra-busqueda").hide();
    		$("#contenido").html(data); // lo que regresa de la busquea 
		    $("#p-busqueda").trigger("reset");
   	 	});
	});







}); // termina query