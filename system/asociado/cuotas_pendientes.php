<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>


<div id="destinoasociado">
  <h2 class="h2-responsive">Listado de cuotas pendientes</h2>

   <?php $asociado->VerCuotasPendientes(); ?>
</div>

<div align="center">
<a href="system/imprimir/imprimir.php?op=1" class="btn btn-primary"><i class="fa fa-print mr-1"></i> Imprimir</a>
</div>

<!-- /// modal ver cleinte -->

<div class="modal" id="ModalPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         PAGAR CUOTA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<div id="vista"></div>
<?php } else { Alerts::Mensajex("No se puede realizar esta acci&oacuten!", "danger"); }
 ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->

