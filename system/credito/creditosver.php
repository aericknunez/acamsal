<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/credito/Creditos.php';
$credito = new Creditos(); 
?>

<div id="msj"></div>
<h2 class="h2-responsive">CREDITOS OTORGADOS</h2>


<div id="contenido">
   <?php $credito->VerCredito(1, "factura", "desc"); ?>
</div>


<!-- modal para ver el credito -->
<div class="modal" id="ModalVerCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CREDITO OTROGADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<!-- <a href="?modal=abonos<?php echo $url; ?>" class="btn btn-secondary btn-rounded">Realizar Abonos</a> -->
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->