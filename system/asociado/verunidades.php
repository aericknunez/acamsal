<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos las Unidades registradas</h2>


<div id="destinoasociado">
   <?php $asociado->VerTodasLasUnidades(); ?>
</div>


<!-- /// modal ver cleinte -->

<div class="modal" id="ModalVerAsociado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES ASOCIADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->
