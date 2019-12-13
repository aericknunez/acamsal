<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["td"] == 100){
$numero = rand(1,9999999999);	
} else {
$numero = 1;	
}

//$numero = 1;

if(isset($_GET["modal"])) { 
echo '
	<script>
		$(document).ready(function()
		{
		  $("#' . $_GET["modal"] . '").modal("show");
		});
	</script>
	';


	if($_GET["modal"] == "registrar"){
	echo '<script type="text/javascript" src="assets/js/query/login.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "newpass"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "userupdate"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "avatar"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_config"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_root"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "img_negocio"){
	echo '<script type="text/javascript" src="assets/js/query/img_negocio.js?v='.$numero.'"></script>';
	}

	/// producto
	if($_GET["modal"] == "proadd"){
	echo '<script type="text/javascript" src="assets/js/query/modal.producto.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "productoBusqueda"){
	echo '<script type="text/javascript" src="assets/js/query/productoBusqueda.js?v='.$numero.'"></script>';
	}


	/// proveedor
	if($_GET["modal"] == "editproveedor"){
	echo '<script type="text/javascript" src="assets/js/query/proveedor.js?v='.$numero.'"></script>';
	}
	/// Cliente
	if($_GET["modal"] == "editcliente"){
	echo '<script type="text/javascript" src="assets/js/query/cliente.js?v='.$numero.'"></script>';
	}


	/// facturar
	if($_GET["modal"] == "facturar"){
	echo '<script type="text/javascript" src="assets/js/query/facturar.js?v='.$numero.'"></script>';
	}


	/// ventas
	if($_GET["modal"] == "cantidad"){
	echo '<script type="text/javascript" src="assets/js/query/ventaPop.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "descuento"){
	echo '<script type="text/javascript" src="assets/js/query/ventaPop.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "credito"){
	echo '<script type="text/javascript" src="assets/js/query/ventaPop.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "dfactura"){
	echo '<script type="text/javascript" src="assets/js/query/ventaPop.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "cliente"){
	echo '<script type="text/javascript" src="assets/js/query/ventaPop.js?v='.$numero.'"></script>';
	}
// abono
	if($_GET["modal"] == "abonos"){
	echo '<script type="text/javascript" src="assets/js/query/credito.js?v='.$numero.'"></script>';
	}
// cotizador
	if($_GET["modal"] == "cantidadc"){
	echo '<script type="text/javascript" src="assets/js/query/cotizaR.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "descuentocot"){
	echo '<script type="text/javascript" src="assets/js/query/cotizaR.js?v='.$numero.'"></script>';
	}


	/// Planilla
	if($_GET["modal"] == "editempleado"){
	echo '<script type="text/javascript" src="assets/js/query/planilla.js?v='.$numero.'"></script>';
	}


	if($_GET["modal"] == "respaldar"){
			$url = "sync/push.php?corte=1";
			echo '<script>
				$(document).ready(function(){

				function Respaldar(){
		                      $.ajax({
		                          type: "POST",
		                          url: "'.$url.'",
		                          success: function(data) {
		                            $("#respaldo").html(data);
		                          }
		                      });
		                  }

		        Respaldar();
		});
		</script>';
	}



} // termina modal

elseif($_SESSION["caduca"] != 0) {
echo '<script type="text/javascript" src="assets/js/query/noacceso.js?v='.$numero.'"></script>';
} 

//config
elseif(isset($_GET["tablas"])) {
echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
} 


elseif(isset($_GET["user"])) {
echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
} 

/// producto
elseif(isset($_GET["proadd"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proopciones"])) {
echo '<script type="text/javascript" src="assets/js/query/proopciones.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["productos"])) {
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/producto_vermodal.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proup"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proagregar"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["proaverias"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["bajasexistencias"])) {
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/producto_vermodal.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["cotizar"])) {
echo '<script type="text/javascript" src="assets/js/query/cotizaR.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["cotizaciones"])) {
echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/cotizaR.js?v='.$numero.'"></script>';
} 



//////////////// proveedor
elseif(isset($_GET["proveedoradd"])) {
echo '<script type="text/javascript" src="assets/js/query/proveedor.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proveedorver"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/proveedordatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/proveedor.js?v='.$numero.'"></script>';
} 

//////////////// cliente
elseif(isset($_GET["clienteadd"])) {
echo '<script type="text/javascript" src="assets/js/query/cliente.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["clientever"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/clientedatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/cliente.js?v='.$numero.'"></script>';
} 

//////////////// creditos
elseif(isset($_GET["creditos"])) {
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/credito.js?v='.$numero.'"></script>';
} 

elseif(isset($_GET["creditospendientes"])) {
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/credito.js?v='.$numero.'"></script>';
} 

//// gastos
elseif(isset($_GET["gastos"])) {
echo '<script type="text/javascript" src="assets/js/query/gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["entradas"])) {
echo '<script type="text/javascript" src="assets/js/query/gastos.js?v='.$numero.'"></script>';
} 
//// corte
elseif(isset($_GET["corte"])) {
echo '<script type="text/javascript" src="assets/js/query/corte.js?v='.$numero.'"></script>';
} 

//// Historial
elseif(isset($_GET["consolidado"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["rdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["vdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["vmensual"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["hcortes"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gmensual"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gra_semanal"])) include_once 'assets/js/query/gra_semanal.php';
elseif(isset($_GET["gra_mensual"])) include_once 'assets/js/query/gra_mensual.php';
elseif(isset($_GET["gra_clientes"])) include_once 'assets/js/query/gra_clientes.php';
elseif(isset($_GET["gra_semestre"])) include_once 'assets/js/query/gra_semestre.php';


// panel de control
elseif(isset($_GET["control"])) {
echo '<script type="text/javascript" src="assets/js/query/control.js?v='.$numero.'"></script>';
include_once 'assets/js/query/gra_control.php';
} 


//////////////// Planilla
elseif(isset($_GET["addempleado"])) {
echo '<script type="text/javascript" src="assets/js/query/planilla.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["verempleado"])) {
echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/planilla.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["descuentos"])) {
echo '<script type="text/javascript" src="assets/js/query/planilla.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["planillasver"])) {
echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/paginador.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/planilla.js?v='.$numero.'"></script>';
} 


else{
/// lo que llevara index
//echo '<script type="text/javascript" src="assets/js/query/ventas.js?v='.$numero.'"></script>';

	if($venta == TRUE){ // si es en venta
		if($tventa == 1){
			echo '<script type="text/javascript" src="assets/js/query/ventaR.js?v='.$numero.'"></script>';
		} else {
			echo '<script type="text/javascript" src="assets/js/query/ventaL.js?v='.$numero.'"></script>';
		}
	} else { // panel de control
			/// query del panel de conttrol a implementar  para root
	}

}
	
?>

<script>
	
	$("body").on("click","#cambiar",function(){
        var op = $(this).attr('op');
        $.post("application/src/routes.php", {op:op}, 
        	function(htmlexterno){
            window.location.href="?";
        });
    });	


// preloader
    $(window).on("load", function () {
        $('#mdb-preloader').fadeOut('fast');
    });


</script>
