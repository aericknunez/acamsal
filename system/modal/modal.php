<style>
    body { 
        background-color: black; /* La página de fondo será negra */
        color: 000; 
    	}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_REQUEST["modal"]=="registrar") include_once 'system/modal/modal/registrar.php';

if($_REQUEST["modal"]=="newpass") include_once 'system/modal/modal/user_cambiar_pass.php';

if($_REQUEST["modal"]=="userupdate") include_once 'system/modal/modal/user_update.php';

if($_REQUEST["modal"]=="avatar") include_once 'system/modal/modal/avatar.php';

if($_REQUEST["modal"]=="conf_config") include_once 'system/modal/modal/conf_config.php';

if($_REQUEST["modal"]=="conf_root") include_once 'system/modal/modal/conf_root.php';

if($_REQUEST["modal"]=="img_negocio") include_once 'system/modal/modal/imagen_negocio.php';

if($_REQUEST["modal"]=="editproveedor") include_once 'system/modal/modal/editar-proveedor.php';

if($_REQUEST["modal"]=="editcliente") include_once 'system/modal/modal/editar-cliente.php';

if($_REQUEST["modal"]=="editasociado") include_once 'system/modal/modal/editar-asociado.php';

// facturar
if($_REQUEST["modal"]=="facturar") include_once 'system/modal/modal/facturar.php';


// producto
if($_REQUEST["modal"]=="proadd") include_once 'system/modal/modal/proadd.php';

if($_REQUEST["modal"]=="productoBusqueda") include_once 'system/modal/modal/productoBusqueda.php';



// venta
if($_REQUEST["modal"]=="cantidad") include_once 'system/modal/modal/cantidad.php';

if($_REQUEST["modal"]=="descuento") include_once 'system/modal/modal/descuento.php';

if($_REQUEST["modal"]=="credito") include_once 'system/modal/modal/credito.php';

if($_REQUEST["modal"]=="dfactura") include_once 'system/modal/modal/dfactura.php';

if($_REQUEST["modal"]=="oventas") include_once 'system/modal/modal/oventas.php';

if($_REQUEST["modal"]=="cliente") include_once 'system/modal/modal/cliente.php';


// creditos
if($_REQUEST["modal"]=="abonos") include_once 'system/modal/modal/creditos_abonos.php';

if($_REQUEST["modal"]=="cre_prodcuto") include_once 'system/modal/modal/creditos_producto.php';

// cotizacion
if($_REQUEST["modal"]=="cantidadc") include_once 'system/modal/modal/cantidad_cotizador.php';

if($_REQUEST["modal"]=="descuentocot") include_once 'system/modal/modal/descuento_cot.php';

if($_REQUEST["modal"]=="respaldar") include_once 'system/modal/modal/respaldar.php';


/// planilla
if($_REQUEST["modal"]=="editempleado") include_once 'system/modal/modal/editar-empleado.php';
