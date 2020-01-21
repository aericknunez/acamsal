<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


// realizo las consultas de los select aqui
    $a = $db->query("SELECT hash, nombre FROM proveedores WHERE td = ".$_SESSION["td"]."");
    $c = $db->query("SELECT hash, categoria FROM producto_categoria WHERE td = ".$_SESSION["td"]."");
    $e = $db->query("SELECT hash, nombre FROM producto_unidades WHERE td = ".$_SESSION["td"]."");


    if ($r = $db->select("cod", "producto", "ORDER BY id desc limit 1")) { 
        $codigox = $r["cod"] + 1;
    } unset($r);  

?>


<div id="msj"></div>

	<form id="form-proadd">
  
  <div class="form-row">
    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Codigo Producto</label>
      <input type="number" class="form-control" id="cod" name="cod" value="<?= $codigox ?>" required>
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Descripci&oacuten</label>
      <input type="text" class="form-control" id="descripcion" name="descripcion" required>
    </div>

  </div>


  <div class="form-row">


    <div class="col-md-4 mb-1 md-form">
      <select class="mdb-select md-form colorful-select dropdown-dark" id="proveedor" name="proveedor">
        <option selected disabled>Proveedor</option>
        <?php foreach ($a as $b) {
        echo '<option value="'. $b["hash"] .'">'. $b["nombre"] .'</option>'; 
        } $a->close(); ?>
      </select>
    </div>


    <div class="col-md-4 mb-1 md-form">
      <select class="mdb-select md-form colorful-select dropdown-dark" id="categoria" name="categoria">
        <option selected disabled>* Categorias</option>
        <?php foreach ($c as $d) {
        echo '<option value="'. $d["hash"] .'">'. $d["categoria"] .'</option>'; 
        } $c->close(); ?>
      </select>
    </div>

    <div class="col-md-4 mb-1 md-form">
        <select class="mdb-select md-form colorful-select dropdown-dark" id="medida" name="medida">
        <option selected disabled>* Unidad de Medida</option>
        <?php foreach ($e as $f) {
        echo '<option value="'. $f["hash"] .'">'. $f["nombre"] .'</option>'; 
        } $e->close();
         ?>
      </select>
    </div>

  </div>

  <div class="form-row">
  	
    <div class="col-md-4 mb-1 md-form">
      <label for="cantidad">* Cantidad</label>
      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
    </div>

    <div class="col-md-4 mb-1 md-form">
      <label for="existencia_minima">* Existencia Minima</label>
      <input type="number" class="form-control" id="existencia_minima" name="existencia_minima" required>
    </div>
	
	<div class="col-md-2 mb-1 md-form">
      	<div class="switch">
            <label>
            * Gravado
              <input type="checkbox" id="gravado" name="gravado">
              <span class="lever"></span>
            </label>
          </div>
    </div>

  <div class="col-md-2 mb-1 md-form">
        <div class="switch">
            <label>
            * Receta
              <input type="checkbox" id="receta" name="receta">
              <span class="lever"></span>
            </label>
          </div>
    </div>

  </div>

  <div class="form-row">
  	
    <div class="col-md-12 mb-1 md-form">
      <textarea id="informacion" name="informacion" class="md-textarea form-control" rows="3"></textarea>
  		<label for="informacion">Informaci&oacuten adicional</label>
    </div>

  </div>


  <div class="form-row">
	
	<div class="col-md-3 mb-1 md-form">
      	<div class="switch">
            <label>
             Servicio ||  Off
              <input type="checkbox" id="servicio" name="servicio">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

	<div class="col-md-3 mb-1 md-form">
      	<div class="switch">
            <label>
             Compuesto ||  Off
              <input type="checkbox" id="compuesto" name="compuesto">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

   <div class="col-md-3 mb-1 md-form">
      	<div class="switch">
            <label>
             Caduca ||  Off
              <input type="checkbox" id="caduca" name="caduca">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

    <div class="col-md-3 mb-1 md-form">
      	<div class="switch">
            <label>
             Dependiente ||  Off
              <input type="checkbox" id="dependiente" name="dependiente">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>






  <div class="form-row mt-5">
  	<div class="col-md-12 md-form text-center">
  	 <button class="btn btn-info" type="submit" id="btn-proadd"><i class="fas fa-save mr-1"></i> Guardar y continuar</button>

  	</div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
