<?php
    include_once 'application/common/Alerts.php'; 
 ?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          ASIGNAR CREDITO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
Cliente:
<div align="center">
  <div class="col-md-12 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="c-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Cliente" aria-label="Search" id="cliente-busqueda" name="cliente-busqueda" autofocus>
        </form>
      </div>
  </div>
  <div class="col-md-12 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>

<div id="ver">
<?php 
if($_SESSION['cliente_credito']){
      $texto = 'Cliente asignado para credito: ' . $_SESSION['cliente_credito']. ".";
    Alerts::Mensajex($texto,"danger",'<a id="quitar-cliente" op="99" class="btn btn-danger btn-rounded">Quitar Cliente</a>',$boton2);
}
 ?>  
</div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->