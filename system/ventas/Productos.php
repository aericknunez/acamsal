<?php 
class Productos{

		public function __construct() { 
     	} 


  public function Busqueda($dato){ // Busqueda para busqueda lenta
    $db = new dbConn();
      if($dato["keyword"] != NULL){
             $a = $db->query("SELECT * FROM producto WHERE cod like '%".$dato["keyword"]."%' or descripcion like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
                if($a->num_rows > 0){
                    echo '<table class="table table-striped table-sm table-hover">';
            foreach ($a as $b) {
                       echo '<tr>
                              <td scope="row"><a id="select-p" cod="'. $b["cod"] .'" descripcion="'. $b["descripcion"] .'">
                              '. $b["cod"] .'  || '. $b["descripcion"] .'</a></td>
                            </tr>'; 
            }  
                        echo '<tr>
                              <td scope="row"><a id="cancel-p">CANCELAR</a></td>
                            </tr>'; 
                $a->close();

                
              } else {
                 echo '<table class="table table-sm table-hover">';
                    echo '<tr>
                              <td scope="row">El criterio de busqueda no corresponde a un producto</td>
                            </tr>';
                    echo '<tr>
                              <td scope="row"><a id="cancel-p">CANCELAR</a></td>
                            </tr>';
             }

          echo '</table>';
      }

  }



  public function TempProducto($dato){ // revisa las propuedades del producto para mostrarlos (lento)
    $db = new dbConn();

  if ($r = $db->select("*", "producto", "WHERE cod = '". $dato["cod"] ."' and td = ".$_SESSION["td"]."")) {  
    $cantidad = $r["cantidad"];
    $medida = $r["medida"];
  } unset($r); 

  if ($s = $db->select("*", "producto_unidades", "WHERE hash = '$medida' and td = ".$_SESSION["td"]."")) { 
    $nombreU = $s["nombre"];
  } unset($s); 

  if ($img = $db->select("imagen", "producto_imagenes", "WHERE producto = '". $dato["cod"] ."' and td = ".$_SESSION["td"]." limit 1")) { 
    $Imagen = $img["imagen"];
  } unset($img); 
if($Imagen == NULL) $Imagen = "default.jpg";


         echo '<section class="my-2">
  <div class="row">
    <div class="col-lg-5 col-xl-4">

      <div class="view overlay rounded z-depth-1-half mb-lg-0 mb-1">
        <img class="img-fluid" src="assets/img/productos/'.$Imagen.'" alt="Titulo del producto">
        <a>
          <div class="mask rgba-white-slight"></div>
        </a>
      </div>

    </div>

    <div class="col-lg-7 col-xl-8">

      <h3 class="font-weight-bold mb-1"><strong>'.$dato["descripcion"].'</strong></h3>
      <p>Cantidad disponible: <a class="font-weight-bold">'.$cantidad.'</a> '.$nombreU.'</p>

      <p class="dark-grey-text">';
    
    if($cantidad <= 0){
       Alerts::Mensajex("No hay productos disponibles en inventario","danger",$boton,$boton2);
    }

    ($cantidad > 0) ? $value = 1 : $value = 0;

      echo '<div class="md-form md-outline form-sm col-md-2">
      <input id="cantidad" name="cantidad" class="form-control form-control-sm" type="number" value="'.$value.'" step="any" max="'. $cantidad .'" min="1">
      <label for="cantidad">Cant</label>
    </div>';

    $this->CompruebaCaracteristicas($dato["cod"]);
    $this->CompruebaUbicaciones($dato["cod"]);
    

    echo '</p>
              <input id="cod" name="cod" type="hidden" value="'. $dato["cod"] .'">
    </div>

  </div>

</section>';

  }



 public function CompruebaCaracteristicas($cod){
  $db = new dbConn();

  $a = $db->query("SELECT * FROM caracteristicas_asig WHERE producto = '$cod' and td = ".$_SESSION["td"]."");

    if($a->num_rows > 0){
        echo 'Caracteristicas a descontar
        <div class="form-row">';
      foreach ($a as $b) {

              if ($r = $db->select("caracteristica", "caracteristicas", "WHERE hash = '". $b["caracteristica"] ."' and td = ".$_SESSION["td"]."")) { 
                  $carac = $r["caracteristica"];
              } unset($r); 

        echo '<div class="col-md-2 mb-1 md-form">
              <label for="cantidad">'. $carac .'</label>
              <input type="number" step="any" class="form-control form-control-sm" id="caracteristica['. $b["caracteristica"] .']" name="caracteristica['. $b["caracteristica"] .']" max="'. $b["cant"] .'">
            </div>';
    } 
      echo '</div>';

    }  $a->close();
    
 }



 public function CompruebaUbicaciones($cod){
  $db = new dbConn();

  $a = $db->query("SELECT * FROM ubicacion_asig WHERE producto = '$cod' and td = ".$_SESSION["td"]."");

    if($a->num_rows > 0){
        echo 'Ubicaci&oacuten de donde descontar&aacute
        <div class="form-row">';
      foreach ($a as $b) {

              if ($r = $db->select("ubicacion", "ubicacion", "WHERE hash = '". $b["ubicacion"] ."' and td = ".$_SESSION["td"]."")) { 
                  $ubi = $r["ubicacion"];
              } unset($r); 

        echo '<div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="'. $b["ubicacion"] .'" name="ubicacion" value="'. $b["ubicacion"] .'">
              <label class="form-check-label" for="'. $b["ubicacion"] .'">'. $ubi .'</label>
            </div>';
    } 
      echo '</div>';

    }  $a->close();

 }







} // Termina la lcase