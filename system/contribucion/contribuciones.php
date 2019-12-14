<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/contribucion/Contribucion.php';
$contribucion = new Contribuciones(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Nueva Contribuci&oacuten</h2>
<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-contribucion">
  
  <div class="form-row">

  <div class="col-md-12 mb-2 md-form">
      <label for="contribucion">* Contribuci&oacuten</label>
      <input type="text" class="form-control" id="contribucion" name="contribucion">
    </div>

  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="cuota">* Cuota</label>
      <input type="number" step="any" class="form-control" id="cuota" name="cuota">
    </div>

   <div class="col-md-6 mb-2 md-form">
      <label for="dias">* Dias</label>
      <input type="number" class="form-control" id="dias" name="dias">
    </div>

  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="mora">* Mora</label>
      <input type="number" step="any" class="form-control" id="mora" name="mora">
    </div>

    <div class="col-md-6 mb-2 md-form">
       <input placeholder="Inicio de cobro" type="text" id="inicio" name="inicio" class="form-control datepicker my-0">
    </div>

  </div>



  <div class="form-row"> 
    <div class="col-md-6 mb-2 md-form">
  <input placeholder="Disponible hasta" type="text" id="vigencia" name="vigencia" class="form-control datepicker my-0">
    </div>

    <div class="col-md-6 mb-2 md-form">
        <select class="browser-default custom-select mb-1" id="tipo" name="tipo">
          <option value="1" selected>Todos</option>
          <option value="2">Por unidad</option>
        </select>
    </div>


  </div>




  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-contribucion"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinocontribucion">
          <?php $contribucion->VerContribuciones(); ?>
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

<p>ADVERTENCIA!! Al elimiar la cuota ya no seguir&aacute generando cobros a los asociados</p>
        <i class="fas fa-times fa-4x animated rotateIn"></i>

<p>Desea continuar?</p>
      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="delcontribucion" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
