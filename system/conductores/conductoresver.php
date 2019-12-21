<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/conductores/Conductor.php';
$conductores = new Conductores(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los Conductores</h2>


<div id="destinoconductor">
   <?php $conductores->VerTodosConductores(); ?>
</div>


<!-- /// modal ver cleinte -->

<div class="modal" id="ModalVerConductor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES CONDUTOR</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="xfoto" op="215" class="btn btn-success btn-rounded">Cambiar Foto</a>
<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
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







        <!-- /// modal ver cleinte -->

<div class="modal" id="ModalFotoConductor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CAMBIAR FOTO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista-foto"></div>
  

<div class="modal-header d-flex justify-content-center">
      <form id="form-foto" name="form-foto" class="md-form">
    
    <div class="file-field row">
          <a class="btn-floating blue-gradient mt-0 float-left btn-sm">
              <i class="fas fa-paperclip" aria-hidden="true"></i>
              <input type="file" id="archivo" name="archivo">
          </a>
          <div class="file-path-wrapper">
             <input class="file-path validate" type="text" placeholder="Agregue su Foto">
          </div>
      </div>
    <input type="hidden" id="iden-foto" name="iden-foto" value="">
  <button class="btn btn-info btn-rounded btn-sm" type="submit" id="btn-foto" name="btn-foto">Subir Foto</button>
  </form>
</div>



<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->













      <!-- /// modal ver sancion -->

<div class="modal" id="ModalSanciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         APLICAR SANCIONES</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista-sanciones"></div>
  

<div class="d-flex justify-content-center">
    <form id="form-sancion" name="form-sancion" class="md-form">
    
        <div class="form-row">
          <div class="col-md-12 mb-1 md-form">
              <select class="browser-default custom-select mb-1" id="sancion" name="sancion">
      <?php 
          $a = $db->query("SELECT sancion, cantidad, hash FROM conductores_sanciones WHERE edo = 1 and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {
        echo '<option value="'.$b["sancion"].'">'.$b["sancion"].'</option>';
        $cantidad = $b["cantidad"];
    } $a->close();
   ?>
              </select>
          </div>
        </div>

      <?php if($cantidad != NULL){
        echo '<input type="hidden" id="cantidad" name="cantidad" value="'.$cantidad.'">';
      } ?>

    <input type="hidden" id="iden-sancion" name="iden-sancion" value="">
  <div align="center"> <button class="btn btn-info btn-rounded" type="submit" id="btn-sancion" name="btn-sancion">APLICAR SANCION</button></div>
  </form>
</div>



<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->