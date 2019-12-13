<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/corte/Corte.php';
$cortes = new Corte;
?>
<div id="corte"></div>

<div align="center" id="contenido">
<?php 
$cortes->Contenido(date("d-m-Y"));
?>
</div>


<!--Modal: modalConfirmDelete-->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Eliminar corte?</p>
      </div>

      <!--Body-->
      <div class="modal-body">
        

		    <div id="content">
        
        <form id="form-cancelar" name="form-cancelar">
     
     <div class="form-group row justify-content-center align-items-center">
      <div class="col-xs-2">
        <label for="ex1">Clave</label>
        <input name="random" type="text" id="random" size="8" maxlength="8" class="form-control" placeholder="HJS4D2" required autofocus />
      </div>
    </div>
    <button class="btn btn-grey" id="btn-cancelar" name="btn-cancelar"><i class="fas fa-times fa-2x animated jello infinite"></i> Eliminar Corte</button>
    </form>

        </div>


      </div>
      <!--Footer-->
      <div class="modal-footer flex-center">
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->