<?php
    include_once 'application/common/Alerts.php'; 
 ?>
 <div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          DATOS DE LA FACTURA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 
if(isset($_REQUEST["add"])){
?>
<h3><?php echo "NUEVO " . $_SESSION['config_nombre_documento']; ?></h3>

<form class="text-center border border-light p-3" id="form-documento" name="form-documento"> 
<input type="text" id="cliente" name="cliente" autocomplete="off" class="form-control mb-3" placeholder="Cliente">  
<input type="text" id="documento" name="documento" autocomplete="off" class="form-control mb-3" placeholder="<?php echo $_SESSION['config_nombre_documento']; ?>">
<button class="btn btn-info btn-block my-4" type="submit" id="btn-documento" name="btn-documento"><?php echo "Agregar " . $_SESSION['config_nombre_documento']; ?></button>
</form>

<?
} else {
?>
<h3><?php echo "INGRESAR " . $_SESSION['config_nombre_documento']; ?></h3>

<div align="center">
  <div class="col-md-12 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="c-documento">
        <input class="form-control" type="text" placeholder="Buscar Cliente" aria-label="Search" id="cliente-documento" name="cliente-documento" autofocus>
        </form>
      </div>
  </div>
  <div class="col-md-12 z-depth-2 justify-content-center" id="muestra-documento"></div>
</div>
<?
}
 ?>

 <div id="ver" class="my-4 text-center">
 <?php 
 if($_SESSION['factura_documento']){
   $texto = $_SESSION['config_nombre_documento']. ": " . $_SESSION["factura_documento"] . "<br> Cliente: " . $_SESSION["factura_cliente"];
    Alerts::Mensajex($texto,"danger",'<a id="quitar-documento" op="102" class="btn btn-danger btn-rounded">Quitar '.$_SESSION["config_nombre_documento"].'</a>',$boton2);            
  }
  ?> 
</div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">
<?php 
if(isset($_REQUEST["add"])){
?> 
 <a href="?modal=dfactura" class="btn btn-secondary btn-rounded">Ingresar <?php  echo $_SESSION['config_nombre_documento'];?></a>
<?
} else {
?>
 <a href="?modal=dfactura&add" class="btn btn-secondary btn-rounded">Nuevo <?php  echo $_SESSION['config_nombre_documento'];?></a>
<?
}
 ?>          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->