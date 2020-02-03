<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

$inicio = Fechas::Format($_REQUEST["fecha1_submit"]);
$fin = Fechas::Format($_REQUEST["fecha2_submit"]);
?>


<div id="destinoasociado">
  <h2 class="h2-responsive">Productos adquiridos por el asociado</h2>

   <?php $asociado->VerProductosAsociado($_REQUEST["asociadoprint"], $inicio, $fin); ?>
</div>

<div align="center">
<a href="system/imprimir/imprimir.php?op=2&as=<?= $_REQUEST["asociadoprint"]; echo '&inicio=' . $inicio .'&fin=' . $fin; ?>" class="btn btn-primary"><i class="fa fa-print mr-1"></i> Imprimir</a>
<a href="?asociadover" class="btn btn-danger"><i class="fa fa-backspace mr-1"></i> Regresar</a>
</div>

