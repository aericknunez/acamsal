<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'system/index/Inicio.php';
include_once 'system/config_configuraciones/Config.php';
$configuracion = new Config;

?>


	
	<div id="cuentas">
		<?php 
		$configuracion->CuentasSucursal($_SESSION['user']);

		 ?>

	</div>

<div class="row d-flex justify-content-center text-center">
	  <div class="col-sm-6">

<?php  if($_SESSION["tipo_cuenta"] == 1){ ?>
	<h3>Usuarios y Sistemas</h3>	

	<form class="text-center border border-light p-2" method="post" id="form-cuentas" name="form-cuentas">
	
    
	<select id="user" name="user" class="browser-default form-control" required="yes">
    <option value="" disabled selected>Elija una Opcion</option>
    <?php 
    $a = $db->query("SELECT * FROM login_userdata");
    foreach ($a as $b) {
    	echo '<option value="'. $b["user"].'">'. $b["nombre"].'</option>';
    } $a->close();
 	?>	
	</select>


	<select id="sistema" name="sistema" class="browser-default form-control" required="yes">
    <option value="" disabled selected>Elija una Opcion</option>
    <?php 
    $a = $db->query("SELECT * FROM config_master");
    foreach ($a as $b) {
    	echo '<option value="'. $b["td"].'">'. $b["cliente"].'</option>';
    } $a->close();
 	?>	
	</select>

	<button class="btn btn-success" type="submit" id="btn-cuentas" name="btn-cuentas">Activar</button>
	</form>

<?php } ?>
	  </div>
	</div>