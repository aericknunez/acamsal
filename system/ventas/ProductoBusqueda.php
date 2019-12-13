<?php 
class ProductoBusqueda{

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
                              <td scope="row"><a id="select-p" cod="'. $b["cod"] .'">
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






public function DetallesProducto($data){
      $db = new dbConn();

// imagen
    if ($r = $db->select("imagen", "producto_imagenes", "WHERE producto = '".$data["key"]."' AND td = ".$_SESSION["td"]." limit 1")) { 
        $img = $r["imagen"];
    } unset($r); 
    if($img == NULL) $img = "default.jpg"; 


    $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto.caduca, producto.compuesto, producto.gravado, producto.receta, producto.dependiente, producto.servicio, producto_categoria.categoria, producto_unidades.nombre, proveedores.nombre as proveedores FROM producto INNER JOIN producto_categoria ON producto.categoria = producto_categoria.hash INNER JOIN producto_unidades ON producto.medida = producto_unidades.hash INNER JOIN proveedores ON producto.proveedor = proveedores.hash WHERE producto.cod = '".$data["key"]."' AND producto.td = ".$_SESSION["td"]."");
    
    if($a->num_rows > 0){
        foreach ($a as $b) {        
          echo '<div class="card card-cascade wider">
<h4 class="card-title"><strong>'. $b["cod"] .' || '. $b["descripcion"].'</strong></h4>

  <div class="view view-cascade overlay">
    <img  class="card-img-top" src="assets/img/productos/'.$img.'" alt="Card image cap">
  </div>


  <div class="card-body card-body-cascade text-center">


    <h5 class="blue-text pb-2"><strong>Existencia: '. $b["cantidad"] .'</strong></h5>';

              $ap = $db->query("SELECT * FROM producto_precio WHERE producto = '".$data["key"]."' AND td = ".$_SESSION["td"]." order by cant asc");
              if($ap->num_rows > 0){
              echo '<h5>Precios Establecidos</h5>';
              echo '<table class="table table-sm table-hover table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                      </tr>
                    </thead>
                    <tbody>';
              foreach ($ap as $bp) {
                 echo '<tr>
                        <td>'.$bp["cant"].'</td>
                        <td><strong>'.Helpers::Dinero($bp["precio"]).'</strong></td>';
              } $ap->close();
              echo '</tbody>
                  </table>';
              } else {
                Alerts::Mensajex("No se he establecido un precio",'danger',$boton,$boton2);
              }


echo '</div>

</div>

</div>';
        }




              $au = $db->query("SELECT ubicacion.ubicacion, ubicacion_asig.cant FROM ubicacion_asig, ubicacion WHERE ubicacion_asig.ubicacion = ubicacion.hash AND ubicacion_asig.producto = '".$data["key"]."' AND ubicacion_asig.td = ".$_SESSION["td"]."");
              if($au->num_rows > 0){
                  echo '<ul class="list-group mt-4">
                        <li class="list-group-item active">Ubicaci&oacuten del Producto</li>';
                  foreach ($au as $bu) {
                     echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$bu["ubicacion"].' 
                     <span class="badge badge-primary badge-pill">'.Helpers::Format($bu["cant"]).'</span></li>';
                  } $au->close();
                  echo '</ul>';
              } 
              $ac = $db->query("SELECT caracteristicas.caracteristica, caracteristicas_asig.cant FROM caracteristicas_asig, caracteristicas WHERE caracteristicas_asig.caracteristica = caracteristicas.hash AND caracteristicas_asig.producto = '".$data["key"]."' AND caracteristicas_asig.td = ".$_SESSION["td"]."");
              if($ac->num_rows > 0){
              echo '<ul class="list-group mt-4">
                    <li class="list-group-item list-group-item-success">Caracteristicas del Producto</li>';
              foreach ($ac as $bc) {
                 echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$bc["caracteristica"].'
                 <span class="badge badge-secondary badge-pill">'.Helpers::Format($bc["cant"]).'</span></li>';
              } $ac->close();
              echo '</ul>';
            } 

      } else {
                Alerts::Mensajex("No se encuentra el producto","danger",$boton,$boton2);
              } $a->close();



          
  }








} // Termina la lcase