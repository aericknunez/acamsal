<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/historial/Historial.php';
?>


<div class="row justify-content-center">
    <div class="col-12 col-md-auto">
     <form name="form-cdiario" method="post" id="form-cdiario">
    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
    </div>
  </div>

<div class="row justify-content-center">
  <button class="btn btn-info my-2 btn-rounded btn-sm waves-effect" type="submit" id="btn-cdiario" name="btn-cdiario">Mostra Datos</button>
  </form> 
</div>


<div id="contenido" class="mt-5">
<?php 
	$historial = new Historial;
	$historial->ConsolidadoDiario(date("d-m-Y"));
 ?>
</div>


<!-- Ver imagenes -->
<div class="modal" id="ModalImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         IMAGENES GASTOS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div id="vista">
</div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
   <a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Cerrar</a>
   
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->