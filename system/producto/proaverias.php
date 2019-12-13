<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/producto/ProUpdate.php';
$producto = new ProUpdate(); 
?>


<div align="center">
  <div class="col-md-6 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" id="producto-averias" name="producto-averias" autofocus>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-averias"></div>
</div>




<?php if($_REQUEST["key"] != NULL){ 
  
  if ($r = $db->select("*", "producto", "WHERE cod = ".$_REQUEST["key"]." and td = ".$_SESSION["td"]."")) { 

$cod = $r["cod"];
$descripcion = $r["descripcion"];  
$caduca = $r["caduca"]; 
  }  unset($r); 


if($cod != NULL){

echo '<h2 class="h2-responsive">'.$descripcion .'</h2>';
  ?>

<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            
<div id="msj"></div>

  <form id="form-productoaverias">
  
  <div class="form-row">
    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Codigo Producto</label>
      <input type="number" class="form-control" id="cod" name="cod" readonly value="<?php echo $cod; ?>">
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Descripci&oacuten</label>
      <input type="text" class="form-control" value="<?php echo $descripcion; ?>" readonly>
    </div>

  </div>



  <div class="form-row">
    
    <div class="col-md-6 mb-1 md-form">
      <label for="cantidad">* Cantidad</label>
      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
    </div>
  </div>

  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-productoaverias"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinoaverias">
          <?php $producto->VerAveria($cod); ?>
    </div>
   
</div>  <!-- row -->

<? } else {
 echo "No se ha encontrado este producto";
}

} 
?>