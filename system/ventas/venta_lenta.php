<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$venta = TRUE;
$tventa = 2;

include_once 'system/ventas/VentasL.php';
$ventas = new Ventas(); 

?>
<div align="center">
  <div class="col-md-6 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
      	<form id="p-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Producto" aria-label="Search" id="producto-busqueda" name="producto-busqueda" autofocus>
        </form>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>
<!-- hasta aqui llega la busqueda -->



<form id="form-addform">

<div id="temp-productos"></div> <!--  producto que viende despues de la busqueda -->


<div align="center"><button class="btn btn-info my-0" type="submit" id="btn-addform"><i class="fas fa-save mr-1"></i> Guardar</button>

<a id="cancel-x" class="btn btn-danger my-0" type="submit" id="btn-addform"><i class="fas fa-ban mr-1"></i> Cancelar</a>
</div>

</form>


<div id="ver">
<?php 
$ventas->VerProducto();	
 ?>
</div>  <!--  Aqui ira el resultado de lo precesado -->
