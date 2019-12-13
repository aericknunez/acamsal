<?php 
class ProUpdate{

		public function __construct() { 
     	} 


  public function UpProducto($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos
                if($datos["gravado"] == NULL) $datos["gravado"] = 0;
                if($datos["receta"] == NULL) $datos["receta"] = 0;
                if($datos["servicio"] == NULL) $datos["servicio"] = 0;
                if($datos["compuesto"] == NULL) $datos["compuesto"] = 0;
                if($datos["caduca"] == NULL) $datos["caduca"] = 0;
                if($datos["dependiente"] == NULL) $datos["dependiente"] = 0;
                $datos["time"] = Helpers::TimeId();
              if (Helpers::UpdateId("producto", $datos, "cod = ".$datos["cod"]." and td = ".$_SESSION["td"]."")) {
                  $this->Redirect($datos);
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }

  }

  public function CompruebaForm($datos){
        if($datos["cod"] == NULL or
          $datos["descripcion"] == NULL or
          $datos["cantidad"] == NULL or
          $datos["existencia_minima"] == NULL or
          $datos["categoria"] == NULL or
          $datos["medida"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function Redirect($datos){
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=2&cad='. $datos["caduca"] .'&com='. $datos["compuesto"] .'&dep='. $datos["dependiente"] .'";
        </script>';
  }



  public function UrlNext($cod, $step,$cad,$com,$dep){
    if($step == "1"){
      header("location: ../../?modal=proadd&key=$cod&step=2&cad=$cad&com=$com&dep=$dep");
    }
      if($step == "2"){
        $db = new dbConn();

        $a = $db->query("SELECT * FROM producto_precio WHERE producto = '$cod' and td = ".$_SESSION["td"]."");
        $precios = $a->num_rows;
        $a->close();
        if($precios == 0){
            header("location: ../../?modal=proadd&key=$cod&step=2&cad=$cad&com=$com&dep=$dep&msj");
        }
        elseif($com == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=3&cad=$cad&com=$com&dep=$dep");
        } 
        elseif($dep == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=4&cad=$cad&com=$com&dep=$dep");
        } else {
          header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep");
        }  
      }
      if($step == "3"){
        if($dep == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=4&cad=$cad&com=$com&dep=$dep");
        } else {
          header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep");
       }  
      }
     if($step == "4"){
        header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep"); 
      }

  }


  public function ProAgrega($datox){ // lo que viede del formulario principal
    $db = new dbConn();

          if($datox["precio"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["cod"];
              $datos["cant"] = $datox["cantidad"];
              $datos["precio_costo"] = $datox["precio"];
              $datos["caduca"] = $datox["caduca_submit"];
              $datos["caducaF"] = Fechas::Format($datox["caduca_submit"]);
              $datos["comentarios"] = $datox["comentarios"];
              $datos["fecha"] = date("d-m-Y");
              $datos["hora"] = date("H:i:s");
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_ingresado", $datos)) {
                // debo actualizar el total (cantidad) de producto
                    if ($r = $db->select("cantidad", "producto", "WHERE cod = ".$datox["cod"]." and td = ".$_SESSION["td"]."")) { 
                        $canti = $r["cantidad"];
                    } unset($r); 
                        $cambio = array();
                        $cambio["cantidad"] = $datox["cantidad"] + $canti;
                        Helpers::UpdateId("producto", $cambio, "cod = ".$datox["cod"]." and td = ".$_SESSION["td"].""); 
                    //////////// 
                Alerts::Alerta("success","Realizado!","Registro creado exitosamente!");
                }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
        $this->VerAgrega($datox["cod"]);
  }


  public function VerAgrega($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_ingresado WHERE producto = '$producto' and td = ".$_SESSION["td"]." order by id desc limit 8");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Precio de Costo</th>
               <th scope="col">Cantidad</th>
              <th scope="col">Caduca</th>
               <th scope="col">Fecha y Hora</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                if($b["caduca"] == NULL) $cad = "N/A"; else $cad = $b["caduca"];
                echo '<tr>
                      <th scope="row">'. $n .'</th>
                      <td>'.$b["precio_costo"].'</td>
                       <td>'.$b["cant"].'</td>
                      <td>'.$cad.'</td>
                      <td>'.$b["fecha"]. ' | ' .$b["hora"] .'</td>';
                if($n == 1 and $b["fecha"] == date("d-m-Y")){
                  echo '<td><a id="delproagrega" hash="'.$b["hash"].'" op="49" producto="'.$producto.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                } else {
                  echo '<td><a><i class="fa fa-ban fa-lg gren-text"></i></a></td>';
                }
                echo '</tr>'; 
                $n ++ ;        
              }
        echo '</tbody>
        </table>';

          } $a->close(); 

      if ($r = $db->select("cantidad", "producto", "WHERE cod = '$producto' and td = ".$_SESSION["td"]."")) { 
       Alerts::Mensajex("La cantidad actual de productos es: " . Helpers::Format($r["cantidad"]),'success',$boton,$boton2);
      }  unset($r);
        
  }


  public function DelProAgrega($hash, $producto){ // elimina precio
    $db = new dbConn();
    // debo actualizar el total (cantidad) de producto
      if ($r = $db->select("cantidad", "producto", "WHERE cod = ".$producto." and td = ".$_SESSION["td"]."")) { 
          $canti = $r["cantidad"];
      } unset($r); 
      if ($r = $db->select("cant, fecha", "producto_ingresado", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 
          $cantix = $r["cant"];
          $fechai = $r["fecha"];
      } unset($r);
                        
                    //////////// 
      if($fechai == date("d-m-Y")){
        if (Helpers::DeleteId("producto_ingresado", "hash='$hash'")) {
          //
                $cambio = array();
                $cambio["cantidad"] = $canti - $cantix;
                Helpers::UpdateId("producto", $cambio, "cod = '$producto' and td = ".$_SESSION["td"].""); 
          //
           Alerts::Alerta("success","Eliminado!","Productos eliminados correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      } else {
        Alerts::Alerta("error","Error!","La fecha del los producto que quiere borrar no coincide!");
      }
      $this->VerAgrega($producto);
  }



public function AgregaBusqueda($dato){ // Busqueda para compuestos
  $db = new dbConn();

        $a = $db->query("SELECT * FROM producto WHERE cod like '%".$dato["keyword"]."%' or descripcion like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
         if($a->num_rows > 0){
          echo '<table class="table table-sm table-hover">';
  foreach ($a as $b) {
             echo '<tr>
                    <td scope="row"><a id="select-agrega" cod="'. $b["cod"] .'" descripcion="'. $b["descripcion"] .'">
                    '. $b["cod"] .'  || '. $b["descripcion"] .'</a></td>
                  </tr>'; 
  }  $a->close();

      echo '
      </table>';
        } else {
          echo "El criterio de busqueda no corresponde a un producto";
        }
}


//////////////// averias
  public function AddAveria($datox){ // lo que viede del formulario principal
    $db = new dbConn();

          if($datox["cantidad"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["cod"];
              $datos["cant"] = $datox["cantidad"];
              $datos["comentarios"] = $datox["comentarios"];
              $datos["fecha"] = date("d-m-Y");
              $datos["hora"] = date("H:i:s");
              $datos["usuario"] = $_SESSION["user"];
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_averias", $datos)) {
                // debo actualizar el total (cantidad) de producto
                    if ($r = $db->select("cantidad", "producto", "WHERE cod = ".$datox["cod"]." and td = ".$_SESSION["td"]."")) { 
                        $canti = $r["cantidad"];
                    } unset($r); 
                        $cambio = array();
                        $cambio["cantidad"] = $canti - $datox["cantidad"];
                        Helpers::UpdateId("producto", $cambio, "cod = ".$datox["cod"]." and td = ".$_SESSION["td"].""); 
                    //////////// 
                Alerts::Alerta("success","Realizado!","Registro creado exitosamente!");
                }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
        $this->VerAveria($datox["cod"]);
  }



    public function VerAveria($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_averias WHERE producto = '$producto' and td = ".$_SESSION["td"]." order by id desc limit 8");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
               <th scope="col">Cantidad</th>
              <th scope="col">Comentarios</th>
               <th scope="col">Fecha y Hora</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                      <th scope="row">'. $n .'</th>
                       <td>'.$b["cant"].'</td>
                      <td>'.$b["comentarios"].'</td>
                      <td>'.$b["fecha"]. ' | ' .$b["hora"] .'</td>';
                if($n == 1 and $b["fecha"] == date("d-m-Y")){
                  echo '<td><a id="delaveria" hash="'.$b["hash"].'" op="52" producto="'.$producto.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                } else {
                  echo '<td><a ><i class="fa fa-ban fa-lg green-text"></i></a></td>';
                }
                echo '</tr>'; 
                $n ++ ;        
              }
        echo '</tbody>
        </table>';

          } $a->close();  
     
           if ($r = $db->select("cantidad", "producto", "WHERE cod = '$producto' and td = ".$_SESSION["td"]."")) { 
       Alerts::Mensajex("La cantidad actual de productos es: " . Helpers::Format($r["cantidad"]),'success',$boton,$boton2);
      }  unset($r);
  }



  public function DelAveria($hash, $producto){ // elimina precio
    $db = new dbConn();
    // debo actualizar el total (cantidad) de producto
        if ($r = $db->select("cantidad", "producto", "WHERE cod = ".$producto." and td = ".$_SESSION["td"]."")) { 
            $canti = $r["cantidad"];
        } unset($r); 
        if ($r = $db->select("cant, fecha", "producto_averias", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 
            $cantix = $r["cant"];
            $fechai = $r["fecha"];
        } unset($r);
                        
                    //////////// 
      if($fechai == date("d-m-Y")){
        if (Helpers::DeleteId("producto_averias", "hash='$hash'")) {
          //
                $cambio = array();
                $cambio["cantidad"] = $canti + $cantix;
                Helpers::UpdateId("producto", $cambio, "cod = ".$producto." and td = ".$_SESSION["td"].""); 
          //
           Alerts::Alerta("success","Eliminado!","Averia eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      } else {
        Alerts::Alerta("error","Error!","La fecha del los producto que quiere borrar no coincide!");
      }
      $this->VerAveria($producto);
  }


public function AveriaBusqueda($dato){ // Busqueda para averia
  $db = new dbConn();

        $a = $db->query("SELECT * FROM producto WHERE cod like '%".$dato["keyword"]."%' or descripcion like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
         if($a->num_rows > 0){
          echo '<table class="table table-sm table-hover">';
  foreach ($a as $b) {
             echo '<tr>
                    <td scope="row"><a id="select-averia" cod="'. $b["cod"] .'" descripcion="'. $b["descripcion"] .'">
                    '. $b["cod"] .'  || '. $b["descripcion"] .'</a></td>
                  </tr>'; 
  }  $a->close();

      echo '</table>';
        } else {
          echo "El criterio de busqueda no corresponde a un producto";
        }
}










} // Termina la lcase