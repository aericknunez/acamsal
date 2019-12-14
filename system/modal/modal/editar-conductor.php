<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Conductor</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "conductores", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$nombre = $r["nombre"];
$documento = $r["documento"];  
$telefono = $r["telefono"]; 
$direccion = $r["direccion"];
$licencia = $r["licencia"]; 
$vlicencia = $r["vlicencia"]; 
$vmt = $r["vmt"]; 
$vvmt = $r["vvmt"];
$comentarios = $r["comentarios"]; 
$tipo = $r["tipo"]; 


  }  unset($r); ?>

<div id="destinoconductor">
  
</div>

 

<form id="form-modconductor">
 <input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">

  <div class="form-row">

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre; ?>">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" value="<?= $documento; ?>">
    </div>

  </div>


  <div class="form-row">

   <div class="col-md-6 mb-2 md-form">
      <label for="telefono">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $telefono; ?>">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="direccion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $direccion; ?>">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="licencia">Licencia</label>
      <input type="text" class="form-control" id="licencia" name="licencia" value="<?= $licencia; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <input placeholder="Vencimiento Licencia" type="text" id="vlicencia" name="vlicencia" class="form-control datepicker my-0"  value="<?= $vlicencia; ?>">

    </div>

  </div>


 

  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="vmt">VMT</label>
      <input type="text" class="form-control" id="vmt" name="vmt" value="<?= $vmt; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <input placeholder="Vencimiento VTM" type="text" id="vvmt" name="vvmt" class="form-control datepicker my-0" value="<?= $vvmt; ?>">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"><?= $comentarios; ?></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>


  <div class="form-row">
    <div class="col-md-12 mb-1 md-form">
        <select class="browser-default custom-select mb-1" id="tipo" name="tipo">
          <option value="1" <?php if($tipo == 1) echo "selected"; ?> >Activo</option>
          <option value="2" <?php if($tipo == 1) echo "selected"; ?> >Diyero</option>
        </select>
    </div>
  </div>


  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-modconductor"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?verconductores" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->