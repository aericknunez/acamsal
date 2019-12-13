<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/cotizar/CotizarR.php';

$cot = new Cotizar(); 
?>

<div id="msj"></div>
<h2 class="h2-responsive">COTIZACIONES EMITIDAS</h2>


<div id="contenido">
   <?php $cot->TodasCotizaciones(1, "correlativo", "asc"); ?>
</div>








<!-- Ver producto -->
<div class="modal" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES DE LA COTIZACION</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="imprimir" class="btn-floating btn-sm blue-gradient"><i class="fa fa-print"></i></a>

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->
