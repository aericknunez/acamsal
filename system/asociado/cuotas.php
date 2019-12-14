<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Listado de cuotas</h2>


<div id="destinoasociado">
   <?php $asociado->VerCuotas(); ?>
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

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->

