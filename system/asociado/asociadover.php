<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los Asociado</h2>


<div id="destinoasociado">
   <?php $asociado->VerTodosAsociados(); ?>
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

<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<a id="btn-unidades" op="195" key="" class="btn btn-success btn-rounded">Unidades</a>
<?php } ?>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->



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



<!-- /// modal ver cleinte -->

<div class="modal" id="ModalUnidades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         UNIDADES DEL ASOCIADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->



  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-extra-tab" data-toggle="tab" href="#nav-extra" role="tab"
        aria-controls="nav-extra" aria-selected="true">Ver Unidades</a>

      <a class="nav-item nav-link" id="nav-descuentos-tab" data-toggle="tab" href="#nav-descuentos" role="tab"
        aria-controls="nav-descuentos" aria-selected="false">Agregar Unidad</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-extra" role="tabpanel" aria-labelledby="nav-extra-tab">

            <div id="vista-unidades"></div>
    
    </div>

    <div class="tab-pane fade" id="nav-descuentos" role="tabpanel" aria-labelledby="nav-descuentos-tab">
    <?php Alerts::Mensajex("Agregue la cantidad del descuento a aplicar","danger"); ?>
    
      
<form id="form-addunidad">
  
   <input type="hidden" id="asociado" name="asociado" value="">

  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="unidad">* Unidad</label>
      <input type="text" class="form-control" id="unidad" name="unidad">
    </div>

   <div class="col-md-6 mb-2 md-form">
      <label for="placa">* Placa</label>
      <input type="text" class="form-control" id="placa" name="placa">
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-addunidad"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

    </div>

  </div>




<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->


















<!-- /// modal ver cleinte -->

<div class="modal" id="ModalPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         PRODUCTOS ADQUIRIDOS POR EL ASOCIADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


    <?php Alerts::Mensajex("Ingresa el rango de fechas a buscar","danger"); ?>
    
      
<form method="post" action="?productos_asociado">
 
   <input type="hidden" id="asociadoprint" name="asociadoprint" value="">

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-cortes" method="post" id="form-cortes">
    <input placeholder="Seleccione una fecha" type="text" id="fecha1" name="fecha1" class="form-control datepicker my-2">
    <input placeholder="Seleccione una fecha" type="text" id="fecha2" name="fecha2" class="form-control datepicker my-2">

    </div>
  </div>


  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto text-center">
    <button class="btn btn-info my-2 btn-rounded btn-sm waves-effect" type="submit" id="btn-cortes" name="btn-cortes">Mostra Datos</button>
      </form> 
    </div>
  </div>

</form>



<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->











<!-- /// modal ver deuda -->

<div class="modal" id="ModalDeuda" tabindex="-1" role="dialog" aria-labelledby="ModalDeuda" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDeuda">
         CREDITOS PENDIENTES</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<div id="vista_deuda"></div>



<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->

