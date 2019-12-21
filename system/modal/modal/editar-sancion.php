<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Sanci&oacuten</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "conductores_sanciones", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$sancion = $r["sancion"];
$cantidad = $r["cantidad"];  

  }  unset($r); ?>

<div id="destinosancion">
  
</div>

 <form id="form-editsancion">

<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">


<div class="form-row">
    
  <div class="col-md-12 mb-2 md-form">
      <label for="sancion">* Sanci&oacuten</label>
      <input type="text" class="form-control" id="sancion" name="sancion" value="<?= $sancion; ?>">
    </div>

</div>


<div class="form-row">
    
   <div class="col-md-12 mb-2 md-form">
      <label for="dias">* Cuota</label>
      <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= $cantidad; ?>">
    </div>

</div>





  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-editsancion"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?sanciones" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->