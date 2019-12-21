<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Nuevo Asociado</h2>
<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-addasociado">
  
  <div class="form-row">

  <div class="col-md-12 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre">
    </div>



  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento">
    </div>

   <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono">
    </div>

  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento" value="Santa Ana">
    </div>



  </div>


 

  <div class="form-row">
 
  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Municipio</label>
      <input type="text" class="form-control" id="municipio" name="municipio" value="Metapan">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Email</label>
      <input type="text" class="form-control" id="email" name="email">
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
        <select class="browser-default custom-select mb-1" id="edo" name="edo">
          <option value="1" selected>Activo</option>
          <option value="2">Inactivo</option>
          <option value="3">NO Asociado</option>
        </select>
    </div>
  </div>



  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-addasociado"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinoasociado">
          <?php $asociado->VerAsociados(); ?>
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

<p>ADVERTENCIA!! Al elimiar un asociado tambi&eacuten se eliminar&aacute toda la informaci&oacuten relacionada a &eacuteste permenentemente.</p>
        <i class="fas fa-times fa-4x animated rotateIn"></i>

<p>Desea continuar?</p>
      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="delasociado" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
