<?php 
    include_once 'system/credito/Creditos.php';
    $credito = new Creditos(); 
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         PRODUCTOS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 
$credito->VerProducto($_REQUEST["factura"], $_REQUEST["tx"])
 ?>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
<?php 
$url = "&cre=" . $_REQUEST["cre"] . "&factura=" . $_REQUEST["factura"]. "&tx=" . $_REQUEST["tx"];
 ?>
<a href="?modal=abonos<?php echo $url; ?>" class="btn btn-secondary btn-rounded">Ver Abonos</a>
<a href="?creditos" class="btn btn-primary btn-rounded">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->