<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/gastos/Gasto.php';
$gasto = new Gastos();

include_once 'system/corte/Corte.php';
$cut = new Corte();
if($cut->UltimaFecha() != date("d-m-Y")){ // comprobacion de corte
?>

<div class="row d-flex justify-content-center">
  <div class="col-md-6">
<h3>GASTOS Y COMPRAS</h3>

<form class="text-center border border-light p-3" id="form-gastos" name="form-gastos">
    
<input type="text"  id="gasto" name="gasto" class="form-control mb-3" placeholder="Gasto">
<select class="browser-default custom-select mb-3" id="tipo" name="tipo">
  <option value="1" selected>GASTOS NO FACTURADOS</option>
  <option value="2">COMPRAS CON FACTURAS</option>
  <option value="3">REMESAS</option>
  <?php if($_SESSION["root_tipo_sistema"] != 3) { // para los que no tienen planilla aqui esta la opcion?>
  <option value="4">ADELANTO A PERSONAL</option>
  <?php } ?>
  <option value="5">CHEQUES</option>
</select>
Descripci&oacuten
<textarea type="text" id="descripcion" name="descripcion" class="form-control mb-3"></textarea>

<input type="number" step="any" id="cantidad" name="cantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-info my-4" type="submit" id="btn-gastos" name="btn-gastos">Agregar Gasto</button>
 </form>

  </div>
</div>

<hr>
<div  class="col-sm-12" id="contenido">
 <?php 
  $gasto->VerGastos();
   ?>
</div> 




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
        <a id="borrar-gasto" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->





<!-- Ver imagenes -->
<div class="modal" id="ModalAddImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         IMAGENES GASTOS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="formulario">
  <form id="form-img" name="form-img" class="md-form">

    <div class="file-field">
        <a class="btn-floating blue-gradient mt-0 float-left">
            <i class="fas fa-paperclip" aria-hidden="true"></i>
            <input type="file" id="archivo" name="archivo">
        </a>
        <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Agregue su imagen">
        </div>
    </div>

  <div class="md-form my-2 ">
      <textarea type="text" id="materialContactFormMessage" class="form-control md-textarea" rows="2" id="descripcion" name="descripcion"></textarea>
      <label for="materialContactFormMessage">Descripci&oacuten de la imagen</label>
  </div>

<input type="hidden" id="codigo" name="codigo" value="">
   
<div class="text-center">
  <button class="btn btn-outline-info btn-rounded z-depth-0 my-2 waves-effect" type="submit" id="btn-img" name="btn-img">Subir Imagen</button>
</div>
    </form>
</div>


<div id="vista">
</div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
    <a id="showform" class="btn btn-danger btn-rounded">Agregar</a>
   <a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Cerrar</a>
   
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->




<?php 
} else { /// termina comprobacion de corte
	Alerts::CorteEcho("Gastos");
}
 ?>