<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div align="center">
  <div class="col-md-6 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" id="producto-busqueda" name="producto-busqueda" autofocus>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>



<div id="contenido">
<?php if($_REQUEST["key"] != NULL){ 
  if ($r = $db->select("*", "producto", "WHERE cod = ".$_REQUEST["key"]." and td = ".$_SESSION["td"]."")) { 

$cod = $r["cod"];
$descripcion = $r["descripcion"];  
$cantidad = $r["cantidad"];
$existencia_minima = $r["existencia_minima"]; 
$gravado = $r["gravado"];
$receta = $r["receta"];
$servicio = $r["servicio"]; 
$compuesto = $r["compuesto"];
$caduca = $r["caduca"]; 
$dependiente = $r["dependiente"];
$informacion = $r["informacion"]; 
$proveedor = $r["proveedor"]; 
$categoria = $r["categoria"];
$medida = $r["medida"]; 
  }  unset($r); 

  
if($cod != NULL){
  ?>
  <div id="msj"></div>

  <form id="form-proup">
  
  <div class="form-row">
    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Codigo Producto</label>
      <input type="number" class="form-control" id="cod" name="cod" readonly value="<?php echo $cod; ?>">
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Descripci&oacuten</label>
      <input type="text" class="form-control" id="descripcion" name="descripcion" required value="<?php echo $descripcion; ?>">
    </div>

  </div>


  <div class="form-row">


    <div class="col-md-4 mb-1 md-form">
      <?php $a = $db->query("SELECT hash, nombre FROM proveedores WHERE td = ".$_SESSION["td"].""); ?>
      <select class="browser-default custom-select" id="proveedor" name="proveedor">
        <option selected disabled>Proveedor</option>
        <?php foreach ($a as $b) {
          if($proveedor == $b["hash"]) $pro = " selected"; else $pro = "";
        echo '<option value="'. $b["hash"] .'"'.$pro.'>'. $b["nombre"] .'</option>'; 
        } $a->close(); ?>
      </select>
    </div>


    <div class="col-md-4 mb-1 md-form">
      <?php $c = $db->query("SELECT hash, categoria FROM producto_categoria WHERE td = ".$_SESSION["td"].""); ?>
      <select class="browser-default custom-select" id="categoria" name="categoria">
        <option selected disabled>* Categorias</option>
        <?php foreach ($c as $d) {
          if($categoria == $d["hash"]) $pro = " selected"; else $pro = "";
        echo '<option value="'. $d["hash"] .'"'.$pro.'>'. $d["categoria"] .'</option>'; 
        } $c->close(); ?>
      </select>
    </div>

    <div class="col-md-4 mb-1 md-form">
      <?php  $e = $db->query("SELECT hash, nombre FROM producto_unidades WHERE td = ".$_SESSION["td"].""); ?>
        <select class="browser-default custom-select" id="medida" name="medida">
        <option selected disabled>* Unidad de Medida</option>
        <?php foreach ($e as $f) {
          if($medida == $f["hash"]) $pro = " selected"; else $pro = "";
        echo '<option value="'. $f["hash"] .'" '.$pro.'>'. $f["nombre"] .'</option>'; 
        } $e->close();
         ?>
      </select>
    </div>

  </div>

  <div class="form-row">
    
    <div class="col-md-4 mb-1 md-form">
      <label for="cantidad">* Cantidad</label>
      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" readonly value="<?php echo $cantidad; ?>">
    </div>

    <div class="col-md-4 mb-1 md-form">
      <label for="existencia_minima">* Existencia Minima</label>
      <input type="number" class="form-control" id="existencia_minima" name="existencia_minima" required value="<?php echo $existencia_minima; ?>">
    </div>
  
  <div class="col-md-2 mb-1 md-form">
        <div class="switch">
            <label>
            * Gravado
              <input type="checkbox" id="gravado" <?php if($gravado == "on") echo "checked"; ?> name="gravado">
              <span class="lever"></span>
            </label>
          </div>
    </div>

  <div class="col-md-2 mb-1 md-form">
        <div class="switch">
            <label>
            * Receta
              <input type="checkbox" id="receta" <?php if($receta == "on") echo "checked"; ?> name="receta">
              <span class="lever"></span>
            </label>
          </div>
    </div>

  </div>

  <div class="form-row">
    
    <div class="col-md-12 mb-1 md-form">
      <textarea id="informacion" name="informacion" class="md-textarea form-control" rows="3"><?php echo $informacion; ?></textarea>
      <label for="informacion">Informaci&oacuten adicional</label>
    </div>

  </div>


  <div class="form-row">
  
  <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Servicio ||  Off
              <input type="checkbox" id="servicio" <?php if($servicio == "on") echo "checked"; ?> name="servicio">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Compuesto ||  Off
              <input type="checkbox" id="compuesto" <?php if($compuesto == "on") echo "checked"; ?> name="compuesto">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

   <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Caduca ||  Off
              <input type="checkbox" id="caduca" <?php if($caduca == "on") echo "checked"; ?> name="caduca">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

    <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Dependiente ||  Off
              <input type="checkbox" id="dependiente" <?php if($dependiente == "on") echo "checked"; ?> name="dependiente">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>






  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-proup"><i class="fa fa-floppy-o mr-1"></i> Guardar y continuar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } else {
 echo "No se ha encontrado este producto";
}

} 
?>
</div> <!-- TERMINA CONTENIDO -->