<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'system/config_configuraciones/Config.php';
$conf = new Config();
?>

<h1 class="h1-responsive">Tablas a actualizar</h1>

<div id="contenido">
  <?php 
$conf->VerTablas();
 ?>
</div>