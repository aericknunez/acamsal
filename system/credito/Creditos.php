<?php 
class Creditos{

		public function __construct() { 
     	} 



  public function VerCredito($npagina, $orden, $dir){
      $db = new dbConn();

  $limit = 12;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM creditos WHERE td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";

 $a = $db->query("SELECT * FROM creditos WHERE td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"><a id="paginador" op="114" iden="1" orden="nombre" dir="'.$dir2.'">Nombre</a></th>
            <th class="th-sm d-none d-md-block"><a id="paginador" op="114" iden="1" orden="factura" dir="'.$dir2.'">Factura</a></th>
            <th class="th-sm"><a id="paginador" op="114" iden="1" orden="fecha" dir="'.$dir2.'">Fecha</a></th>
            <th class="th-sm"><a id="paginador" op="114" iden="1" orden="edo" dir="'.$dir2.'">Estado</a></th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

          echo '<tr>
                      <td>'.$b["nombre"].'</td>
                      <td class="d-none d-md-block">'.$b["factura"].'</td>
                      <td>'.$b["fecha"]. ' | ' . $b["hora"].'</td>
                      <td>'.Helpers::EstadoCredito($b["edo"]) . '</td>
                      <td><a id="xver" op="109" credito="'. $b["hash"] .'" factura="'. $b["factura"] .'" tx="'. $b["tx"] .'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }
echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="114" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="114" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="114" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="114" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="114" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 
  } // termina productos



 
  public function ObtenerTotal($factura, $tx){ // total del credito
    $db = new dbConn();

        if ($r = $db->select("sum(total)", "ticket", "WHERE num_fac = '$factura' and tx = '$tx' and td = ".$_SESSION["td"]."")) { 
            return $r["sum(total)"];
        }  unset($r);  
    
  }


  public function TotalAbono($credito){ // total abonos
    $db = new dbConn();

    if ($r = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '$credito' and edo = 1 and td = ".$_SESSION["td"]."")) { 
            return $r["sum(abono)"];
        }  unset($r);  
    
  }




  public function VerProducto($factura, $tx) { //leva el control del autoincremento de los clientes
    $db = new dbConn();
        
        $a = $db->query("SELECT * FROM ticket WHERE num_fac = '$factura' and tx = '$tx' and td = ".$_SESSION["td"]."");

        if($a->num_rows > 0){
            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Cant</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Impuesto</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>';
            $pv = 0; $stotal = 0; $imp = 0; $tot = 0;
            foreach ($a as $b) {
              $pv = $pv + $b["pv"]; $stotal = $stotal + $b["stotal"]; $imp = $imp + $b["imp"]; $tot = $tot + $b["total"];
            echo '<tr>
                  <th scope="row">'.$b["cant"].'</th>
                  <td>'.$b["producto"].'</td>
                  <td>'.$b["pv"].'</td>
                  <td>'.$b["stotal"].'</td>
                  <td>'.$b["imp"].'</td>
                  <td>'.$b["total"].'</td>
                </tr>';
            }
              echo '<tr>
                  <th></th>
                  <td></td>
                  <th>'.Helpers::Dinero($pv).'</th>
                  <th>'.Helpers::Dinero($stotal).'</th>
                  <th>'.Helpers::Dinero($imp).'</th>
                  <th>'.Helpers::Dinero($tot).'</th>
                </tr>
                </tbody>
              </table>';
        } $a->close();

   
  }









public function VerAbonos($credito) { //leva el control del autoincremento de los clientes
    $db = new dbConn();
        
        $a = $db->query("SELECT * FROM creditos_abonos WHERE credito = '$credito' and edo = 1 and td = ".$_SESSION["td"]." order by id desc");

        if($a->num_rows > 0){

    if ($r = $db->select("factura, tx", "creditos", "WHERE hash = '$credito' and edo = 1 and td = ".$_SESSION["td"]."")) { 
        $factura = $r["factura"]; $tx = $r["tx"];
    }  unset($r); 

            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Abono</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>';
            $n = 1;
            foreach ($a as $b) {
            echo '<tr>
                  <th scope="row">'.$b["nombre"].'</th>
                  <td>'.Helpers::Dinero($b["abono"]).'</td>
                  <td>'.$b["fecha"].'</td>
                  <td>'.$b["hora"].'</td>';

                      if($n == 1 and $b["fecha"] == date("d-m-Y")){
                      echo '<td><a id="delabono" hash="'.$b["hash"].'" op="108" credito="'.$b["credito"].'" factura="'.$factura.'" tx="'.$tx.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                    } else {
                      echo '<td><i class="fa fa-ban fa-lg green-text"></i></td>';
                    }
              echo '</tr>';
            $n ++;
            }
              echo '</tbody>
              </table>';
        } else{
          Alerts::Mensajex("A&uacuten no se ha realizado ningun abono","danger",$boton,$boton2);
        } $a->close();

   
  }



  public function AddAbono($datos){
    $db = new dbConn();
      if($datos["credito"] != NULL and $datos["abono"] != NULL){ // comprueba dtos
        
        $tot = $this->ObtenerTotal($datos["factura"], $datos["tx"]);
        $abo = $this->TotalAbono($datos["credito"]);
        $resultado = Helpers::Format($tot - $abo);
        $abono = Helpers::Format($datos["abono"]);

          if($abono <= $resultado){
                $data["credito"] = $datos["credito"];
                $data["nombre"] = strtoupper($datos["nombre"]);
                $data["abono"] = $datos["abono"];
                $data["user"] = $_SESSION["user"];
                $data["fecha"] = date("d-m-Y");
                $data["hora"] = date("H:i:s");
                $data["edo"] = 1;
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("creditos_abonos", $data)) {

                       Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                        $abo2 = $this->TotalAbono($datos["credito"]);
                        $resultado2 = $tot - $abo2;
                       if($resultado2 == 0){
                            $cambio = array();
                            $cambio["edo"] = 2;
                            Helpers::UpdateId("creditos", $cambio, "hash='".$datos["credito"]."' and td = ".$_SESSION["td"].""); 
                       }

                }
          } else {
            Alerts::Alerta("error","Error!","La cantidad ingresada es mayor al credito!");
          }
        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerAbonos($datos["credito"]);
  }



  public function DelAbono($hash, $credito){ // elimina abono
    $db = new dbConn();
          $cambios = array();
          $cambios["edo"] = 2;
          $cambios["user_del"] = $_SESSION["user"];
          $cambios["hora_del"] = date("H:i:s");
      if(Helpers::UpdateId("creditos_abonos", $cambios, "hash='$hash' and td = ".$_SESSION["td"]."")){
        
           Alerts::Alerta("success","Eliminado!","Abono Eliminado correctamente!");
                    $cambio = array();
                    $cambio["edo"] = 1;
                    Helpers::UpdateId("creditos", $cambio, "hash='$credito' and td = ".$_SESSION["td"].""); 
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerAbonos($credito);
  }





  public function LlamarVista($credito, $factura, $tx){
      $db = new dbConn();
      $this->VerProducto($factura, $tx);
 
      $creditos = $this->ObtenerTotal($factura, $tx);
      $abonos = $this->TotalAbono($credito);

      echo '<div class="form-group row justify-content-center align-items-center">
        <div class="text-center border border-light mr-5">
         Total Abonado:
          <h1>'.Helpers::Dinero($abonos).'</h1>
        </div>
        <div class="text-center border border-light text-danger mr-5">
         Total pendiente:
          <h1>'.Helpers::Dinero($creditos - $abonos).'</h1>
        </div>
    </div>';
    
  }








  public function CreditosPendientes($npagina, $orden, $dir){
      $db = new dbConn();

  $limit = 12;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM creditos WHERE edo = 1 and td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";

 $a = $db->query("SELECT * FROM creditos WHERE edo = 1 and td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"><a id="paginador" op="104" iden="1" orden="nombre" dir="'.$dir2.'">Nombre</a></th>
            <th class="th-sm d-none d-md-block"><a id="paginador" op="104" iden="1" orden="factura" dir="'.$dir2.'">Factura</a></th>
            <th class="th-sm">Total</th>
            <th class="th-sm">Abonado</th>
            <th class="th-sm">Saldo</th>
            <th class="th-sm"><a id="paginador" op="104" iden="1" orden="fecha" dir="'.$dir2.'">Fecha</a></th>
            <th class="th-sm"><a id="paginador" op="104" iden="1" orden="edo" dir="'.$dir2.'">Estado</a></th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

        $total = $this->ObtenerTotal($b["factura"], $b["tx"], $b["orden"]);
        $abonado = $this->TotalAbono($b["hash"]);
        $saldo = $total - $abonado;

          echo '<tr>
                      <td>'.$b["nombre"].'</td>
                      <td class="d-none d-md-block">'.$b["factura"].'</td>
                      <td>'. Helpers::Dinero($total) .'</td>
                      <td>'. Helpers::Dinero($abonado) .'</td>
                      <td>'. Helpers::Dinero($saldo) .'</td>
                      <td>'.$b["fecha"]. ' | ' . $b["hora"].'</td>
                      <td>'.Helpers::EstadoCredito($b["edo"]) . '</td>
                      <td><a id="xver" op="109" credito="'. $b["hash"] .'" factura="'. $b["factura"] .'" tx="'. $b["tx"] .'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }

/// se establece cuanto es el total en credito pendiente
echo '<div class="font-weight-bold">Total Credito Pendiente: ' . Helpers::Dinero($this->TotalCreditoOtorgado() - $this->TotalAbonoRealiado()) . '</div><br>';


echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="104" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="104" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="104" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="104" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="104" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 
  } // termina productos







  public function BusquedaCreditos($dato){ // Busqueda para busqueda lenta
    $db = new dbConn();
      if($dato["keyword"] != NULL){
             $a = $db->query("SELECT * FROM asociados WHERE nombre like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
                if($a->num_rows > 0){
                    echo '<table class="table table-striped table-sm table-hover">';
            foreach ($a as $b) {
                       echo '<tr>
                              <td scope="row"><a id="select-p" op="111" cliente="'. $b["hash"] .'">
                              '. $b["nombre"] .'</a></td>
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


  public function MuestraBusquedaCreditos($dato){ // Busqueda para busqueda lenta
    $db = new dbConn();

 $a = $db->query("SELECT * FROM creditos WHERE hash_cliente = '".$dato["cliente"]."' and edo != 0 and td = ".$_SESSION["td"]." order by edo");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm">Nombre</th>
            <th class="th-sm d-none d-md-block">Factura</th>
            <th class="th-sm">Total</th>
            <th class="th-sm">Abonado</th>
            <th class="th-sm">Saldo</th>
            <th class="th-sm">Fecha</th>
            <th class="th-sm">Estado</th>
            <th class="th-sm">Ver</th>
          </tr>
        </thead>
        <tbody>';

        $saldox = 0;
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

        $total = $this->ObtenerTotal($b["factura"], $b["tx"], $b["orden"]);
        $abonado = $this->TotalAbono($b["hash"]);
        $saldo = $total - $abonado;

        $saldox = $saldox + $saldo;

          echo '<tr>
                      <td>'.$b["nombre"].'</td>
                      <td class="d-none d-md-block">'.$b["factura"].'</td>
                      <td>'. Helpers::Dinero($total) .'</td>
                      <td>'. Helpers::Dinero($abonado) .'</td>
                      <td>'. Helpers::Dinero($saldo) .'</td>
                      <td>'.$b["fecha"]. ' | ' . $b["hora"].'</td>
                      <td>'.Helpers::EstadoCredito($b["edo"]) . '</td>
                      <td><a id="xver" op="109" credito="'. $b["hash"] .'" factura="'. $b["factura"] .'" tx="'. $b["tx"] .'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>';


        /// se establece cuanto es el total en credito pendiente
echo '<div class="font-weight-bold">Total Credito Pendiente de '. $b["nombre"] . ': ' . Helpers::Dinero($saldox) . '</div><br>';



      } else {
        Alerts::Mensajex("No se encontraron creditos en este cliente","danger");
      }
        $a->close();

}










public function TotalCreditoOtorgado(){ // total del credito que se ha otorgado en todo el tiempo
  $db = new dbConn();

      if ($r = $db->select("sum(total)", "ticket", "WHERE tipo_pago = 3 and edo = 1 and td = ".$_SESSION["td"]."")) { 
          return $r["sum(total)"];
      }  unset($r);  
  
}


public function TotalAbonoRealiado(){ // total abonos realiados en todo el tiempo
  $db = new dbConn();

  if ($r = $db->select("sum(abono)", "creditos_abonos", "WHERE edo = 1 and td = ".$_SESSION["td"]."")) { 
          return $r["sum(abono)"];
      }  unset($r);  
  
}






} // Termina la lcase