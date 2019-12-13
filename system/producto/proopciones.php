<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/producto/Productos.php';
$producto = new Productos(); 
?>


<!-- Classic tabs -->
<div class="classic-tabs">

  <ul class="nav tabs-cyan" id="myClassicTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link  waves-light active show" id="steps-tab-classic" data-toggle="tab" href="#steps-classic"
        role="tab" aria-controls="steps-classic" aria-selected="true">CATEGORIAS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="unidades-tab-classic" data-toggle="tab" href="#unidades-classic" role="tab"
        aria-controls="unidades-classic" aria-selected="false">UNIDADES DE MEDIDA</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="caracteristicas-tab-classic" data-toggle="tab" href="#caracteristicas-classic" role="tab"
        aria-controls="caracteristicas-classic" aria-selected="false">CARACTERISTICAS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="ubicacion-tab-classic" data-toggle="tab" href="#ubicacion-classic" role="tab"
        aria-controls="ubicacion-classic" aria-selected="false">UBICACIONES</a>
    </li>

  </ul>
  <div class="tab-content border-right border-bottom border-left rounded-bottom" id="myClassicTabContent">
    <div class="tab-pane fade active show" id="steps-classic" role="tabpanel" aria-labelledby="steps-tab-classic">

      <?php Alerts::Mensaje("Categorias de los productos","success",$boton,$boton2); ?>


		<div class="row">
		    <div class="col-md-6 btn-outline-info z-depth-2" id="origencategoria">
                
				<!-- Inicia Formulario -->
                <form id="form-addcategoria">
  
                  <div class="form-row">
                    <div class="col-md-8 mb-2 md-form">
                      <label for="cod">Categoria</label>
                      <input type="text" class="form-control" id="categoria" name="categoria" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-addcategoria"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>

              </form>
				<!-- Termina Formulario -->

		    </div>
		    
		    <div class="col-md-6 btn-outline-danger z-depth-2" id="destinocategoria">
		        <?php 
		           $producto->VerCategoria();        
		         ?>
		    </div>
		   
		</div>

    </div> <!-- termina tab -->


    <div class="tab-pane fade" id="unidades-classic" role="tabpanel" aria-labelledby="unidades-tab-classic">
      <?php Alerts::Mensaje("Unidades de medida","success",$boton,$boton2); ?>
         
		<div class="row">
		    <div class="col-md-6 btn-outline-info z-depth-2" id="origenunidad">
                
				<!-- Inicia Formulario -->
                <form id="form-addunidad">
  
                  <div class="form-row">
                    <div class="col-md-6 mb-2 md-form">
                      <label for="cod">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-2 mb-2 md-form">
                      <label for="cod">Abreviacion</label>
                      <input type="text" class="form-control" id="abreviacion" name="abreviacion" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-addunidad"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>

              </form>
				<!-- Termina Formulario -->

		    </div>
		    
		    <div class="col-md-6 btn-outline-danger z-depth-2" id="destinounidad">
		        <?php 
		           $producto->VerUnidad();        
		         ?>
		    </div>
		   
		</div>

    </div> <!-- termina tab -->


    <div class="tab-pane fade" id="caracteristicas-classic" role="tabpanel" aria-labelledby="caracteristicas-tab-classic">
      <?php Alerts::Mensaje("Caracteristicas del producto","success",$boton,$boton2); ?>

		<div class="row">
		    <div class="col-md-6 btn-outline-info z-depth-2" id="origencaracteristica">
                
				<!-- Inicia Formulario -->
                <form id="form-addcarateristica">
  
                  <div class="form-row">
                    <div class="col-md-8 mb-2 md-form">
                      <label for="cod">Caracteristica</label>
                      <input type="text" class="form-control" id="caracteristica" name="caracteristica" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-addcarateristica"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>

              </form>
				<!-- Termina Formulario -->

		    </div>
		    
		    <div class="col-md-6 btn-outline-danger z-depth-2" id="destinocaracteristica">
		        <?php 
		           $producto->VerCaracteristica();        
		         ?>
		    </div>
		   
		</div>

    </div> <!-- termina tab -->

    <div class="tab-pane fade" id="ubicacion-classic" role="tabpanel" aria-labelledby="ubicacion-tab-classic">
      <?php Alerts::Mensaje("Ingrese la ubicacion de sus productos","success",$boton,$boton2); ?>
      
		<div class="row">
		    <div class="col-md-6 btn-outline-info z-depth-2" id="origenubicacion">
                
				<!-- Inicia Formulario -->
                <form id="form-addubicacion">
  
                  <div class="form-row">
                    <div class="col-md-8 mb-2 md-form">
                      <label for="cod">Ubicaci&oacuten</label>
                      <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-addubicacion"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>

              </form>
				<!-- Termina Formulario -->

		    </div>
		    
		    <div class="col-md-6 btn-outline-danger z-depth-2" id="destinoubicacion">
		        <?php 
		           $producto->VerUbicacion();        
		         ?>
		    </div>
		   
		</div>

    </div> <!-- termina tab -->



  </div>

</div>
<!-- Classic tabs -->


<!-- MODAL PARA CONFIRMAR ELIMINACION -->

<div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Seguro que desea eliminar este elemento?</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-times fa-4x animated rotateIn"></i>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="btn-modal" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->