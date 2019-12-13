<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          CANTIDAD DE PRODUCTO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div align="center">
  <div class="col-md-12 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="form-Ccantidad">
        <input class="form-control form-control-lg" type="number" step="any" min="1" placeholder="Cantidad" id="cantidad" name="cantidad" value="<?php echo $_REQUEST["cant"]; ?>" autofocus>
        <input type="hidden" id="cod" name="cod" value="<?php echo $_REQUEST["cod"]; ?>">
         <button class="btn aqua-gradient btn-rounded btn-sm" type="submit" id="btn-Ccantidad" name="btn-Ccantidad">Agregar</button>
        </form>
      </div>
  </div>
</div>

<div id="ver"></div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->