<?php
    include_once 'application/common/Alerts.php'; 
    include_once 'system/cotizar/Laterales.php';
    $lateral = new Laterales(); 


 ?>

<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          DESCUENTO A COTIZACION</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

       <form id="form-descuento">

          <div class="form-row">
            <div class="col-md-8 mb-2 md-form">
              <label for="cod">Cantidad</label>
              <input type="text" class="form-control" id="descuento" name="descuento" required>
            </div>

          <div class="col-md-4 mb-4 md-form">
              <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-descuento"><i class="fas fa-plus"></i></button> %
            </div>

          </div>

      </form>

<div id="ver">
  <?php 
if($_SESSION['descuento_cot'] != NULL){


    $precio = $lateral->ObtenerTotal($_SESSION["cotizacion"]);
  $texto = 'El total en esta venta es de: ' . $precio;
  Alerts::Mensajex($texto,"success",$boton,$boton2);



  $texto = 'Esta venta posee un descuento de : ' . $_SESSION['descuento_cot']. " %";
  Alerts::Mensajex($texto,"danger",'<a id="quitar-descuento" op="156" class="btn btn-danger btn-rounded">Quitar Descuento</a>',$boton2);
} else {
    $precio = $lateral->ObtenerTotal($_SESSION["cotizacion"]);
  $texto = 'El total en esta venta sin descuento es de: ' . $precio;
  Alerts::Mensajex($texto,"success",$boton,$boton2);
}
?>

</div>
<!-- ./  content -->



      </div>
      <div class="modal-footer">

          <a href="?cotizar" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->