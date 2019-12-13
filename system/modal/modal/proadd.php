<?php 
include_once 'application/common/Alerts.php';
include_once 'system/producto/Productos.php';
  $productos = new Productos;

$key =  $_REQUEST["key"];
$cad = $_REQUEST["cad"];
$com = $_REQUEST["com"];
$dep = $_REQUEST["dep"];

    if ($r = $db->select("descripcion", "producto", "WHERE cod = '$key' and td = ".$_SESSION["td"]."")) { 
        $prod = $r["descripcion"];
    } unset($r);  

 ?>

<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <?php echo $prod; ?></h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<!-- Classic tabs -->
<div class="classic-tabs">

  <ul class="nav tabs-cyan" id="myClassicTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link  waves-light active show" id="steps-tab-classic" data-toggle="tab" href="#steps-classic"
        role="tab" aria-controls="steps-classic" aria-selected="true">NECESARIOS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="imagenes-tab-classic" data-toggle="tab" href="#imagenes-classic" role="tab"
        aria-controls="imagenes-classic" aria-selected="false">Imagenes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="etiquetas-tab-classic" data-toggle="tab" href="#etiquetas-classic" role="tab"
        aria-controls="etiquetas-classic" aria-selected="false">Etiquetas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="ubicacion-tab-classic" data-toggle="tab" href="#ubicacion-classic" role="tab"
        aria-controls="ubicacion-classic" aria-selected="false">Ubicacion</a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-light" id="caracteristicas-tab-classic" data-toggle="tab" href="#caracteristicas-classic" role="tab"
        aria-controls="caracteristicas-classic" aria-selected="false">Caracteristicas</a>
    </li>

  </ul>
  <div class="tab-content border-right border-bottom border-left rounded-bottom" id="myClassicTabContent">
    <div class="tab-pane fade active show" id="steps-classic" role="tabpanel" aria-labelledby="steps-tab-classic">

          <?php if($_REQUEST["step"] == 1) { ?>
            <p class="note note-secondary"><strong>Precio de Costo:</strong> El precio de costo es de suma importantancia para que el sistema calcule sus margenes de ganancias</p>
              <div class="row d-flex justify-content-center text-center" id="preciocosto"> 
                <div class="col-sm-6">
                <div id="msj"></div>
                      <form id="form-preciocosto">
  
                        <div class="form-row">
                        <div class="col-md-12 mb-1 md-form">
                          <label for="precio_costo">Precio de costo</label>
                          <input type="number" step="any" class="form-control" id="precio_costo" name="precio_costo" required>
                        </div>
                        </div>

                        <!-- caduca -->
                        <?php if($_REQUEST["cad"] == "on"){
                          echo '<input placeholder="Seleccione una fecha" type="text" id="caduca" name="caduca" class="form-control datepicker my-2">
                        <label for="caduca">Fecha de caducidad</label>';
                        } ?>
                        
                        <div class="form-row">
                        <div class="col-md-12 mb-1 md-form">
                          <label for="comentarios">Comentarios</label>
                          <textarea name="comentarios" id="comentarios" class="form-control"></textarea>
                        </div>
                        </div>


                        <div class="form-row">
                          <div class="col-md-12 my-1 md-form text-center">
                           <button class="btn btn-info my-1" type="submit" id="btn-preciocosto"><i class="fa fa-floppy-o mr-1"></i> Guardar</button>

                          </div>
                        </div>
                      <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
                      <input type="hidden" id="cad" name="cad" value="<?php echo $_REQUEST["cad"] ?>" >
                      <input type="hidden" id="dep" name="dep" value="<?php echo $_REQUEST["dep"] ?>" >
                      <input type="hidden" id="com" name="com" value="<?php echo $_REQUEST["com"] ?>" >
                      </form>

                </div>
              </div> <!-- termina primer formulario -->
              <?php }
              if($_REQUEST["step"] == 2) {                 
                ?>
            <p class="note note-secondary"><strong>Precio de Venta:</strong> Es necesario que agregue al menos un precio de venta, el precio por unidad equivale a cantidad 1 y precio x</p>
              <div class="row d-flex justify-content-center text-center" id="precios"> 
                <div class="col-sm-12">

                <form id="form-precios">
  
                  <div class="form-row">
                    <div class="col-md-4 mb-2 md-form">
                      <label for="cod">Cantidad</label>
                      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-4 mb-2 md-form">
                      <label for="cod">Precio</label>
                      <input type="number" step="any" class="form-control" id="precio" name="precio" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-precios"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                      <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
                      <input type="hidden" id="cad" name="cad" value="<?php echo $_REQUEST["cad"] ?>" >
                      <input type="hidden" id="dep" name="dep" value="<?php echo $_REQUEST["dep"] ?>" >
                      <input type="hidden" id="com" name="com" value="<?php echo $_REQUEST["com"] ?>" >
              </form>


              <div id="muestraprecios"><?php 
              if(isset($_GET["msj"])) Alerts::Mensaje("Debe agregar un precio del producto","danger",$boton,$boton2);
             $productos->VerPrecios($_REQUEST["key"]); 
              ?></div>
         <?php $url = "application/src/routes.php?op=47&key=$key&step=2&cad=$cad&com=$com&dep=$dep"; ?>
              <a href="<?php echo $url; ?>" class="btn btn-info my-1" type="submit" id="btn-preciosdone"><i class="fa fa-floppy-o mr-1"></i> Continuar</a>
              </div>
              </div>

    <!-- termina precios formulario -->
            <?php }
              if($_REQUEST["step"] == 3) { 
                ?>
              <p class="note note-secondary"><strong>Producto Compuesto:</strong> Este producto se compone de uno o mas productos, inserte la cantidad de productos que comprenden este producto</p>

          <div class="row d-flex justify-content-center text-center" id="compuesto"> 
                <div class="col-sm-12">

                <form id="form-compuesto">
  
                  <div class="form-row">
                    <div class="col-md-2 mb-2 md-form">
                      <label for="cod">Cantidad</label>
                      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-8 mb-2 md-form">
                    <label for="cod">producto</label>
                    <input type="text" step="any" class="form-control" id="producto-busqueda" name="producto-busqueda" autocomplete="off">
                    <input type="hidden" id="producto-codigo" name="producto-codigo">
                    </div>

                  <div class="col-md-2 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-compuesto"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                  <div id="muestra-busqueda"></div>
                      <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
                      <input type="hidden" id="cad" name="cad" value="<?php echo $_REQUEST["cad"] ?>" >
                      <input type="hidden" id="dep" name="dep" value="<?php echo $_REQUEST["dep"] ?>" >
                      <input type="hidden" id="com" name="com" value="<?php echo $_REQUEST["com"] ?>" >
              </form>
               
                    <div id="muestraproductos">
                      <?php 
               $productos->VerCompuesto($_REQUEST["key"]); 
                ?></div>
          <?php $url = "application/src/routes.php?op=47&key=$key&step=3&com=$com&dep=$dep"; ?>
              <a href="<?php echo $url; ?>" class="btn btn-info my-1" type="submit" id="btn-preciosdone"><i class="fa fa-floppy-o mr-1"></i> Continuar</a>
              </div>
               </div>
    <!-- termina compuesto formulario -->
            <?php }
              if($_REQUEST["step"] == 4) { 
                    ?>
            <p class="note note-secondary"><strong>Producto Dependiente:</strong> Este producto depende de otro producto, ingrese la cantidad y e l producto que este lo comprende</p>
          <div class="row d-flex justify-content-center text-center" id="dependiente"> 
                <div class="col-sm-12">

                <form id="form-dependiente">
  
                  <div class="form-row">
                    <div class="col-md-2 mb-2 md-form">
                      <label for="cod">Cantidad</label>
                      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-8 mb-2 md-form">
                      <label for="cod">producto</label>
                      <input type="text" step="any" class="form-control" id="producto-busqueda" name="producto-busqueda" required>
                    </div>
                    <input type="hidden" id="producto-codigo" name="producto-codigo">
                  <div class="col-md-2 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-dependiente"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                  <div id="muestra-busqueda"></div>
                      <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
                      <input type="hidden" id="cad" name="cad" value="<?php echo $_REQUEST["cad"] ?>" >
                      <input type="hidden" id="dep" name="dep" value="<?php echo $_REQUEST["dep"] ?>" >
                      <input type="hidden" id="com" name="com" value="<?php echo $_REQUEST["com"] ?>" >
              </form>
                    <div id="muestradependiente"><?php 
                  $productos->VerDependiente($_REQUEST["key"]); 
                ?></div>
          <?php $url = "application/src/routes.php?op=47&key=$key&step=4&com=$com&dep=$dep"; ?>
              <a href="<?php echo $url; ?>" class="btn btn-info my-1" type="submit" id="btn-preciosdone"><i class="fa fa-floppy-o mr-1"></i> Continuar</a>
              </div>
               </div>
    <!-- termina compuesto formulario -->
            <?php }
              if($_REQUEST["step"] == 5) { ?>
                  <blockquote class="blockquote bq-success">
                  <p class="bq-title">Realizado</p>
                  <p>Se han ingresado con &eacutexito todos los datos importantes requeridos por el sistema.</p>
                </blockquote>
            <?php }  ?>
    </div> <!-- termina tab -->


    <div class="tab-pane fade" id="imagenes-classic" role="tabpanel" aria-labelledby="imagenes-tab-classic">
      <p class="note note-primary"><strong>Imagenes:</strong> Ingrese una o mas imagenes del producto, estas serviran pra identificarlo mejor</p>

      <!-- formulario para imagens -->
        <form id="form-img" name="form-img" class="md-form">

    <div class="file-field">
        <a class="btn-floating blue-gradient mt-0 float-left">
            <i class="fas fa-paperclip" aria-hidden="true"></i>
            <input type="file" id="archivo" name="archivo">
        </a>
        <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Agregue su imagen">
        </div>
    </div>

  <div class="md-form my-4 ">
      <textarea type="text" id="materialContactFormMessage" class="form-control md-textarea" rows="3" id="descripcion" name="descripcion"></textarea>
      <label for="materialContactFormMessage">Descripci&oacuten de la imagen</label>
  </div>

<input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>">
       
<div align="center"><button class="btn btn-outline-info btn-rounded z-depth-0 my-4 waves-effect" type="submit" id="btn-img" name="btn-img">Subir Imagen</button></div>
    
    </form>
<div id="contenido-img">
 <?php 
include_once 'application/common/ImagenesSuccess.php';
$imgs = new Success();
$imgs->VerProducto($_REQUEST["key"], "assets/img/productos/");
  ?> 
</div>
      <!-- form -->
    </div> <!-- termina tab -->


    <div class="tab-pane fade" id="etiquetas-classic" role="tabpanel" aria-labelledby="etiquetas-tab-classic">
      <p class="note note-primary"><strong>Etiquetas:</strong> Ingrese palabras claves que identifican a su produto, estas serviran para hacer una busqueda mas adecuada</p>

                <div class="row d-flex justify-content-center text-center" id="etiqueta"> 
                <div class="col-sm-12">

                <form id="form-etiqueta">
  
                  <div class="form-row">
                    <div class="col-md-8 mb-2 md-form">
                      <label for="etiquetas">Etiqueta</label>
                      <input type="text" class="form-control" id="etiquetas" name="etiquetas" required>
                    </div>

                  <div class="col-md-4 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-etiqueta"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                          <div id="muestra-busqueda"></div>
                        <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
              </form>
                    <div id="muestraetiqueta"><?php 
                  $productos->VerTag($_REQUEST["key"]); 
                ?></div>
              
              </div>
               </div>
    <!-- termina compuesto formulario -->
    </div> <!-- termina tab -->

    <div class="tab-pane fade" id="ubicacion-classic" role="tabpanel" aria-labelledby="ubicacion-tab-classic">
      <p class="note note-primary"><strong>Ubicaci&oacuten:</strong> La ubicaci&oacuten del producto es donde se encuentra fisicamente.</p>
      
      <div class="row d-flex justify-content-center text-center" id="ubicacion"> 
                <div class="col-sm-12">
                <div id="cuentaproductos">  <?php   echo $productos->CuentaProductosU($_REQUEST["key"]) . ' PRODUCTOS EN TOTAL'; ?> </div>
                <form id="form-ubicacionasig" name="form-ubicacionasig">
  
                  <div class="form-row">
                    <div class="col-md-2 mb-2 md-form">
                      <label for="cod">Cantidad</label>
                      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-8 mb-2 md-form" id="select-ubicacion">
                    <?php   $productos->SelectUbicacion(); ?>
                    </div>

                  <div class="col-md-2 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-ubicacionasig" name="btn-ubicacionasig"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                    <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
              </form>


              <div id="muestraubicacionasig">
                <?php 
                  $productos->VerUbicacionAsig($_REQUEST["key"]); 
                ?>
              </div>

              <a class="btn btn-info my-1" type="submit" data-toggle="modal" data-target="#modal-ubicacion"><i class="fa fa-plus mr-1"></i> Nueva Ubicacion</a>
              </div>
              </div>

    <!-- termina precios formulario -->

    </div> <!-- termina tab -->


    <div class="tab-pane fade" id="caracteristicas-classic" role="tabpanel" aria-labelledby="caracteristicas-tab-classic">
      <p class="note note-primary"><strong>Caracteristicas:</strong> Ingrese caracteristicas independientes que poseen su producto</p>
            
            <div class="row d-flex justify-content-center text-center" id="caracteristicas"> 
                <div class="col-sm-12">
                <div id="cuentaproductos">  <?php   echo $productos->CuentaProductosU($_REQUEST["key"]) . ' PRODUCTOS EN TOTAL'; ?> </div>
                <form id="form-caracteristicasasig" name="form-caracteristicasasig">
  
                  <div class="form-row">
                    <div class="col-md-2 mb-2 md-form">
                      <label for="cod">Cantidad</label>
                      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-8 mb-2 md-form"  id="select-caracteristica">
                      <?php  $productos->SelectCaracteristica(); ?>
                    </div>

                  <div class="col-md-2 mb-4 md-form">
                      <button class="btn-floating btn-sm btn-secondary" type="submit" id="btn-caracteristicasasig" name="btn-caracteristicasasig"><i class="fa fa-plus"></i></button>
                    </div>

                  </div>
                         <input type="hidden" id="producto" name="producto" value="<?php echo $_REQUEST["key"] ?>" >
              </form>


              <div id="muestracaracteristicaasig">
                <?php 
                  $productos->VerCaracteristicaAsig($_REQUEST["key"]); 
                ?>
              </div>
              <a class="btn btn-info my-1" type="submit" data-toggle="modal" data-target="#modal-caracteristicas"><i class="fa fa-plus mr-1"></i> Nueva Caracteristica</a>
              </div>
              </div>

    <!-- termina precios formulario -->


          </div> <!-- termina tab -->



  </div>

</div>
<!-- Classic tabs -->





<!-- ./  content -->
      </div>
      
          
          <?php // aparece hasta terminar el ingreso
              if($_REQUEST["step"] == 5) {  ?>
               <div class="modal-footer">
                  <a href="?" class="btn btn-primary btn-rounded">TERMINAR</a>
              </div>
            <?php }  ?>
          
    </div>
  </div>
</div>
<!-- ./  Modal -->


<!-- probar con nuevo modal para agregar ubicaciones y caracteristicas nuevas -->

<!-- Modal -->
<div class="modal fade" id="modal-ubicacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Ubicaci&oacuten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
                    
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
                    <div id="destinoubicacion">
            <?php 
               $productos->VerUbicacion();        
             ?>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-caracteristicas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Caracteristica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
                    <div id="destinocaracteristica">
            <?php 
               $productos->VerCaracteristica();        
             ?>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>











<!-- MODAL PARA CONFIRMAR ELIMINACION -->

<div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Seguro que desea elimiar este elemento?</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-times fa-4x animated rotateIn"></i>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="btn-modal" class="btn  btn-outline-danger">Elimiar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->