<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/conductores/Conductor.php';
$conductor = new Conductores(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Nuevo Conductor</h2>
<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-addconductor">
  
  <div class="form-row">

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento">
    </div>

  </div>


  <div class="form-row">

   <div class="col-md-6 mb-2 md-form">
      <label for="telefono">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="direccion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="licencia">Licencia</label>
      <input type="text" class="form-control" id="licencia" name="licencia">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <input placeholder="Vencimiento Licencia" type="text" id="vlicencia" name="vlicencia" class="form-control datepicker my-0">

    </div>

  </div>


 

  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="vmt">VMT</label>
      <input type="text" class="form-control" id="vmt" name="vmt">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <input placeholder="Vencimiento VTM" type="text" id="vvmt" name="vvmt" class="form-control datepicker my-0">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>


  <div class="form-row">
    <div class="col-md-12 mb-1 md-form">
        <select class="browser-default custom-select mb-1" id="tipo" name="tipo">
          <option value="1" selected>Activo</option>
          <option value="2">Dillero</option>
        </select>
    </div>
  </div>


  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-addconductor"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinoconductor">
          <?php $conductor->VerConductores(); ?>
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

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="delconductor" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
