<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["caduca"] != 0) include_once 'system/index/noacceso.php';

elseif(isset($_GET["modal"])) include_once 'system/modal/modal.php';

elseif(isset($_GET["user"])) include_once 'system/user/user.php';

elseif(isset($_GET["configuraciones"])) include_once 'system/config_configuraciones/configuraciones.php';

elseif(isset($_GET["root"])  and $_SESSION['tipo_cuenta'] == "1") include_once 'system/config_configuraciones/root.php';
elseif(isset($_GET["tablas"])) include_once 'system/config_configuraciones/tablas.php';

// producto
elseif(isset($_GET["proadd"])) include_once 'system/producto/proadd.php'; // agregar
elseif(isset($_GET["proopciones"])) include_once 'system/producto/proopciones.php'; //opciones
elseif(isset($_GET["productos"])) include_once 'system/producto/producto.php'; //todos los productos
elseif(isset($_GET["proup"])) include_once 'system/producto/proup.php'; // actualizar
elseif(isset($_GET["proagregar"])) include_once 'system/producto/proagregar.php'; // agregar producto
elseif(isset($_GET["proaverias"])) include_once 'system/producto/proaverias.php'; // agregar averias
elseif(isset($_GET["bajasexistencias"])) include_once 'system/producto/bajasexistencias.php'; 
elseif(isset($_GET["cotizar"])) include_once 'system/cotizar/cotizar.php'; 
elseif(isset($_GET["cotizaciones"])) include_once 'system/cotizar/cotizaciones.php'; 


// proveedores
elseif(isset($_GET["proveedoradd"])) include_once 'system/proveedor/proveedores.php'; // agregar proveedores
elseif(isset($_GET["proveedorver"])) include_once 'system/proveedor/proveedorver.php'; // proveedores


// asociados
elseif(isset($_GET["asociadoadd"])) include_once 'system/asociado/asociados.php'; // agregar asociado
elseif(isset($_GET["asociadover"])) include_once 'system/asociado/asociadover.php'; // ver asociados
elseif(isset($_GET["asociaunidades"])) include_once 'system/asociado/verunidades.php'; // ver unidades
elseif(isset($_GET["cuotas"])) include_once 'system/asociado/cuotas.php'; // ver unidades
elseif(isset($_GET["cuotaspendientes"])) include_once 'system/asociado/cuotas_pendientes.php'; // ver unidades


// contribuciones
elseif(isset($_GET["contribucionadd"])) include_once 'system/contribucion/contribuciones.php'; // agregar asociado


// Conductore
elseif(isset($_GET["conductoradd"])) include_once 'system/conductores/conductores.php'; 
elseif(isset($_GET["verconductores"])) include_once 'system/conductores/conductoresver.php';
elseif(isset($_GET["con_vencidos"])) include_once 'system/conductores/vencidos.php';



// clientes
elseif(isset($_GET["clienteadd"])) include_once 'system/cliente/clientes.php'; // agregar cliente
elseif(isset($_GET["clientever"])) include_once 'system/cliente/clientever.php'; // ver clientes


// creditos
elseif(isset($_GET["creditos"])) include_once 'system/credito/creditosver.php'; // ver todos los creditos
elseif(isset($_GET["creditospendientes"])) include_once 'system/credito/creditospendientes.php'; // pendientes


// Gastos y compras
elseif(isset($_GET["gastos"])) include_once 'system/gastos/gastos.php'; 
elseif(isset($_GET["entradas"])) include_once 'system/gastos/entradas.php'; 


// Corte Diario
elseif(isset($_GET["corte"])) include_once 'system/corte/cortes.php'; 



// Historia;
elseif(isset($_GET["consolidado"])) include_once 'system/historial/consolidado_diario.php';
elseif(isset($_GET["vdiario"])) include_once 'system/historial/vdiario.php'; 
elseif(isset($_GET["vmensual"])) include_once 'system/historial/vmensual.php'; 
elseif(isset($_GET["hcortes"])) include_once 'system/historial/hcortes.php'; 
elseif(isset($_GET["gdiario"])) include_once 'system/historial/gdiario.php'; 
elseif(isset($_GET["gmensual"])) include_once 'system/historial/gmensual.php'; 

// graficos;
elseif(isset($_GET["gra_semanal"])) include_once 'system/historial/gra_semanal.php';
elseif(isset($_GET["gra_mensual"])) include_once 'system/historial/gra_mensual.php';
elseif(isset($_GET["gra_clientes"])) include_once 'system/historial/gra_clientes.php';
elseif(isset($_GET["gra_semestre"])) include_once 'system/historial/gra_semestre.php';



// Panel de Control
elseif(isset($_GET["control"])) include_once 'system/control/control.php';


// planilla
elseif(isset($_GET["addempleado"])) include_once 'system/planilla/empleados.php'; // agregar planilla
elseif(isset($_GET["verempleado"])) include_once 'system/planilla/empleadover.php'; // ver empleados
elseif(isset($_GET["descuentos"])) include_once 'system/planilla/descuentos.php'; // ver descuentos
elseif(isset($_GET["planillasver"])) include_once 'system/planilla/planillasver.php'; // ver planilla


else{
include_once 'system/index/index.php';
}
	
?>