<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Contribuci&oacuten</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "asociados_contribuciones", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$contribucion = $r["contribucion"];
$cuota = $r["cuota"];  
$dias = $r["dias_activos"]; 
$mora = $r["mora"];
$vigencia = $r["vigencia"]; 

  }  unset($r); ?>

<div id="destinocontribucion">
  
</div>

 <form id="form-editcontribucion">

<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">

  <div class="form-row">

  <div class="col-md-12 mb-2 md-form">
      <label for="contribucion">* Contribuci&oacuten</label>
      <input type="text" class="form-control" id="contribucion" name="contribucion" value="<?php echo $contribucion; ?>">
    </div>

  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="cuota">* Cuota</label>
      <input type="number" step="any" class="form-control" id="cuota" name="cuota" value="<?php echo $cuota; ?>">
    </div>

   <div class="col-md-6 mb-2 md-form">
      <label for="dias">* Dias</label>
      <input type="number" class="form-control" id="dias" readonly="yes" name="dias" value="<?php echo $dias; ?>">
    </div>

  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="mora">* Mora</label>
      <input type="number" step="any" class="form-control" id="mora" name="mora" value="<?php echo $mora; ?>">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <input placeholder="Vigencia hasta" type="text" id="vigencia" name="vigencia" class="form-control datepicker my-0" value="<?php echo $vigencia; ?>">
    </div>

  </div>






  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-editcontribucion"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?contribucionadd" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->