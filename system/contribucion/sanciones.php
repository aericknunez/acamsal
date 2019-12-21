<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/contribucion/Contribucion.php';
$contribucion = new Contribuciones(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Nueva Sanci&oacuten</h2>
<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-sancion">
  

  <div class="form-row">
    
  <div class="col-md-8 mb-2 md-form">
      <label for="sancion">* Sanci&oacuten</label>
      <input type="text" class="form-control" id="sancion" name="sancion">
    </div>

   <div class="col-md-4 mb-2 md-form">
      <label for="dias">* Cuota</label>
      <input type="number" class="form-control" id="cantidad" name="cantidad">
    </div>

  </div>





  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-sancion"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinosancion">
          <?php $contribucion->VerSanciones(); ?>
    </div>
   
</div>  <!-- row -->



<!-- MODAL PARA CONFIRMAR ELIMINACION -->

<div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Seguro que desea eliminar este elemento?</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-times fa-4x animated rotateIn"></i>

<p>Desea continuar?</p>
      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="delsancion" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
