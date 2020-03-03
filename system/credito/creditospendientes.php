<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/credito/Creditos.php';
$credito = new Creditos(); 
?>

<div id="msj"></div>
<h2 class="h2-responsive">CREDITOS PENDIENTES 
  <a id="busqueda" class="btn-floating btn-success btn-sm mb-3" title="Buscar Credito"><i class="fas fa-search"></i></a></h2> 


<div id="contenido">
   <?php $credito->CreditosPendientes(1, "factura", "asc"); ?>
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




<!-- modal para buscar el credito -->
<div class="modal" id="BuscadorCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CREDITO OTROGADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div align="center">
  <div class="col-md-12 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="p-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Credito" aria-label="Search" id="key" name="key" autofocus>

        </form>
      </div>
  </div>
  <div class="col-md-12 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>

<div id="muestra-busqueda"> </div>

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