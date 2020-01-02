<?php 
class Conductores {

		public function __construct() { 
     	} 



  public function AddConductor($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $data["nombre"] = strtoupper($datos["nombre"]);
                $data["documento"] = $datos["documento"];
                $data["telefono"] = $datos["telefono"];
                $data["direccion"] = $datos["direccion"];
                $data["licencia"] = $datos["licencia"];
                $data["vlicencia"] = $datos["vlicencia_submit"];
                $data["vlicenciaF"] = Fechas::Format($datos["vlicencia_submit"]);
                $data["vmt"] = $datos["vmt"];
                $data["vvmt"] = $datos["vvmt_submit"];
                $data["vvmtF"] = Fechas::Format($datos["vvmt_submit"]);
                $data["comentarios"] = $datos["comentarios"];
                $data["tipo"] = $datos["tipo"];
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("conductores", $data)) {

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerConductores();

  }


  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL or
          $datos["documento"] == NULL or
          $datos["direccion"] == NULL or
          $datos["telefono"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpConductores($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $data["nombre"] = strtoupper($datos["nombre"]);
                $data["documento"] = $datos["documento"];
                $data["telefono"] = $datos["telefono"];
                $data["direccion"] = $datos["direccion"];
                $data["licencia"] = $datos["licencia"];
                $data["vlicencia"] = $datos["vlicencia_submit"];
                $data["vlicenciaF"] = Fechas::Format($datos["vlicencia_submit"]);
                $data["vmt"] = $datos["vmt"];
                $data["vvmt"] = $datos["vvmt_submit"];
                $data["vvmtF"] = Fechas::Format($datos["vvmt_submit"]);
                $data["comentarios"] = $datos["comentarios"];
                $data["tipo"] = $datos["tipo"];
                $data["time"] = Helpers::TimeId();
                $hash = $datos["hash"];
              if (Helpers::UpdateId("conductores", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?verconductores"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerConductores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM conductores WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Licencia</th>
              <th scope="col">Telefono</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["licencia"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="212"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?verconductores" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelConductor($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("conductores", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Conductor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerConductores();
  }

  public function DelConductorx($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("conductores", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Conductor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosConductores();
  }


  public function VerTodosConductores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM conductores WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Tipo</th>
                    <th class="th-sm">Detalles</th>
                    <th class="th-sm">Opciones</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                ($b["tipo"] == 1) ? $tipo = "Activo" : $tipo = "Dillero";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.$tipo.'</td>
                      <td><a id="xver" op="214" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="213"><i class="fa fa-minus-circle fa-lg red-text"></i></a>
                      <a id="print" hash="'.$b["hash"].'" op="186"><i class="fa fa-print fa-lg blue-text"></i></a>
                      <a id="xsancion" key="'.$b["hash"].'" op="223"><i class="fa fa-exclamation-triangle fa-lg orange-text"></i></a>
                      </td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Tipo</th>
                    <th>Detalles</th>
                    <th>Opciones</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }





  public function VistaConductor($data){
      $db = new dbConn();

      $fechax = Fechas::Format(date("d-m-Y")) + 1296000;

     if ($r = $db->select("*", "conductores", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 

($r["foto"] != NULL) ? $foto = $r["foto"] : $foto = "default.jpg";
echo '<section id="about" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 text-center">
                   <img src="assets/img/conductores/'.$foto.'" alt="User Photo" class="z-depth-1 mb-3 img-fluid" />

                  <div>
                    
                  </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        
                          <blockquote class="blockquote bq-danger">
                          <p class="bq-title">'.$r["nombre"].'</p>
                          <p>'.$r["comentarios"].'</p>
                        </blockquote>

                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Documento: </span> <span class="pro-detail">'.$r["documento"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Direcci&oacuten: </span> <span class="pro-detail">'.$r["direccion"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Licencia: </span> <span class="pro-detail">'.$r["licencia"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span>'; 
                  if($r["vlicencia"] < $fechax) $color = "danger-color";
                  echo 'Vencimiento: </span> <span class="pro-detail '.$color.'">'.$r["vlicencia"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> VMT: </span> <span class="pro-detail">'.$r["vmt"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Vencimiento: </span> <span class="pro-detail">'.$r["vvmt"].'</span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Tel&eacutefono: </span> <span class="pro-detail">'.$r["telefono"].'</span></li>
                </ul>

                  <div class="row">
                        <div class="col-md-6 my-6 md-form text-left">
                     

                    </div>
                    <div class="col-md-6 my-6 md-form text-right">

                    </div>
                  </div>


               </div>


                </div>
            </div>
        </section>';

          $this->VerSansionesAsig($data["key"]);
        }  unset($r); 


  }






  public function Vencidos(){
      $db = new dbConn();

        $fechax = Fechas::Format(date("d-m-Y")) + 1296000;

          $a = $db->query("SELECT * FROM conductores WHERE vlicenciaF < '".$fechax."' or vvmtF < '".$fechax."' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Detalles</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xver" op="214" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Detalles</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encuentra ning&uacuten conductor con documentos vencidos","success");
          } $a->close();  

  }








  public function VerSansionesAsig($key){
      $db = new dbConn();


          $a = $db->query("SELECT * FROM conductores_sanciones_asig WHERE conductor = '$key' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
             Alerts::Mensajex("Sanciones establecidas a &eacuteste conductor","danger");
        echo '<table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Sanci&oacuten</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                ($b["edo"] == 1) ? $edo = "Activo" : $edo = "Cancelado";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["sancion"].'</td>
                      <td>'.Helpers::Dinero($b["cantidad"]).'</td>
                      <td>'.$b["fecha"].'</td>
                      <td>'.$edo.'</td>
                    </tr>';          
              }
        echo '</tbody>
              </table><hr>';

          } else {
            Alerts::Mensajex("No se encuentra ning&uacutena sanci&oacuten en este conductor","success");
          } $a->close();  

  }




/////////////////////////// sanciones //////////////
  public function AddSancion($datos){
    $db = new dbConn();
      if($datos["sancion"] != NULL or $datos["cantidad"] != NULL){ 

                $data["sancion"] = strtoupper($datos["sancion"]);
                $data["cantidad"] = $datos["cantidad"];
                $data["conductor"] = $datos["iden-sancion"];
                $data["fecha"] = date("d-m-Y");
                $data["hora"] = date("H:i:s");
                $data["fechaF"] = Fechas::Format(date("d-m-Y"));
                $data["edo"] = 1;
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("conductores_sanciones_asig", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }
        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerSansionesAsig($datos["iden-sancion"]);

  }



  public function Sancionados(){
      $db = new dbConn();

          $a = $db->query("SELECT * FROM conductores_sanciones_asig WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Sanci&oacuten</th>
                    <th>Cantidad</th>
                    <th>Conductor</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                ($b["edo"] == 1) ? $edo = '<a id="pagar" op="226" hash="'.$b["hash"].'"><i class="fas fa-money-bill-alt fa-lg green-text"></i> COBRAR</a>' : $edo = "CANCELADO";
                
                ($b["edo"] == 1 and $b["fecha"] == date("d-m-Y")) ? $del = '<a id="xdelete" hash="'.$b["hash"].'" op="225"><i class="fa fa-minus-circle fa-lg red-text"></i></a>' : $del = '<i class="fa fa-ban fa-lg red-text"></i>';
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["sancion"].'</td>
                      <td>'.Helpers::Dinero($b["cantidad"]).'</td>
                      <td>'.$this->NombreConductor($b["conductor"]).'</td>
                      <td>'.$b["fecha"].'</td>
                      <td id="idcuota'.$b["hash"].'">'.$edo.'</td>
                      <td><a id="xver" op="214" key="'.$b["conductor"].'"><i class="fas fa-search fa-lg green-text"></i></a> '.$del.'</td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Sanci&oacuten</th>
                    <th>Cantidad</th>
                    <th>Conductor</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encuentra ning&uacuten conductor con documentos vencidos","success");
          } $a->close();  

  }

  public function NombreConductor($key){
      $db = new dbConn();
    if ($r = $db->select("nombre", "conductores", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 
        return $r["nombre"];
    } unset($r);  
}

  public function DelSancion($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("conductores_sanciones_asig", "hash='$hash' and edo = 1")) {
           Alerts::Alerta("success","Eliminado!","Elemento eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->Sancionados();
  }



public function Cuota($hash){
      $db = new dbConn();
        if ($r = $db->select("*", "conductores_sanciones_asig", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 

         echo '<div class="text-center"><h4>'.$r["sancion"].'</h4>
          <h1>'.Helpers::Dinero($r["cantidad"]).'</h1>
          <a id="cobrar" hash="'.$hash.'" op="227" class="btn btn-success btn-rounded">Cobrar</a>
          </div>';

        }  unset($r); 
    }


public function Cobrar($hash){
      $db = new dbConn();

    $data = array();
    $data["fecha_pago"] = date("d-m-Y");
    $data["fecha_pagoF"] = Fechas::Format(date("d-m-Y"));
    $data["edo"] = 2;
    $data["time"] = Helpers::TimeId();
    if (Helpers::UpdateId("conductores_sanciones_asig", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
        Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");        

      } else {
      Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  

    }











} // Termina la lcase