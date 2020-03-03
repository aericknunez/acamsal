<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/producto/Productos.php';
$producto = new Productos(); 
?>

<div id="msj"></div>
<h2 class="h2-responsive">PRODUCTOS CON BAJAS EXISTANCIAS</h2>


<div id="contenido">
   <?php $producto->BajasExistencias(1, "producto.id", "asc"); ?>
</div>

<div class="row justify-content-center">
  <a href="system/imprimir/imprimir.php?op=11" class="btn btn-info my-2 btn-rounded btn-sm waves-effect" title="Imprimir todos los productos">Imprimir Todo</a>
</div>


<!-- Ver producto -->
<div class="modal" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES PRODUCTO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<?php if($_SESSION["tipo_cuenta"] != 4) { ?>
<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<? } ?>
<? } ?>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->
