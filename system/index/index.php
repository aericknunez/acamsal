<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/index/Inicio.php';
include_once 'system/corte/Corte.php';
$cut = new Corte();

if($_SESSION["cotizacion"]){
Alerts::Mensajex("ADVERTENCIA! Se detecto una cotizaci&oacuten sin concluir.", "danger", '<a href="?cotizar" class="btn btn-danger">ir a Cotizacionez</a>');
}

echo '<div id="ventana"></div>';

if($cut->UltimaFecha() != date("d-m-Y")){ // comprobacion de corte
	if($_SESSION["tipo_inicio"] == 2){ 	include_once 'system/ventas/venta_lenta.php'; } 
	else { include_once 'system/ventas/venta_rapida.php'; }

} else { /// termina comprobacion de corte
	Alerts::CorteEcho("ventas");
}

?>