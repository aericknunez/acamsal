<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Asociado</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "asociados", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$nombre = $r["nombre"];
$documento = $r["documento"];  
$direccion = $r["direccion"]; 
$municipio = $r["municipio"];
$departamento = $r["departamento"]; 
$telefono = $r["telefono"]; 
$email = $r["email"];
$contacto = $r["contacto"]; 
$comentarios = $r["comentarios"]; 
$edo = $r["edo"]; 
  }  unset($r); ?>

<div id="destinoasociado">
  
</div>

<form id="form-editasociado">
  
  <div class="form-row">

<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">
  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $documento; ?>">
    </div>

  </div>


  <div class="form-row">

 <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo $departamento; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Municipio</label>
      <input type="text" class="form-control" id="municipio" name="municipio" value="<?php echo $municipio; ?>">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Email</label>
      <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Nombre Contacto</label>
      <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $contacto; ?>">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"> <?php echo $comentarios; ?></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>

  <div class="form-row">
    <div class="col-md-12 mb-1 md-form">
        <select class="browser-default custom-select mb-1" id="edo" name="edo">
          <option value="1" <?php if($edo == 1) echo "selected"; ?> >Activo</option>
          <option value="2" <?php if($edo == 1) echo "selected"; ?> >Inactivo</option>
          <option value="3" <?php if($edo == 3) echo "selected"; ?> >No Asociado</option>
        </select>
    </div>
  </div>


  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-editasociado"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?asociadover" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->