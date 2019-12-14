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
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Ver</th>
                    <th class="th-sm">Eliminar</th>
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
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="213"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }





  public function VistaConductor($data){
      $db = new dbConn();
     if ($r = $db->select("*", "conductores", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 

              echo '<table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nombre: '.$r["nombre"].'</th>
                    <td>Documento: '.$r["documento"].'</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2">Direcci&oacuten: '.$r["direccion"].'</th>
                  </tr>
                  <tr>
                    <td>Licencia: '.$r["Licencia"].'</td>
                    <td>Vencimiento: '.$r["vlicencia"].'</td>
                  </tr>
                  <tr>
                    <td>VMT: '.$r["vmt"].'</td>
                    <td>Vencimiento: '.$r["vvmt"].'</td>
                  </tr>
                  <tr>
                    <td>Telefono: '.$r["telefono"].'</td>
                    <td>Comentarios: '.$r["comentarios"].'</td>
                  </tr>
                </tbody>
              </table>'; 

        }  unset($r); 


  }






  public function Vencidos(){
      $db = new dbConn();

        $fechax = Fechas::Format(date("d-m-Y"));

          $a = $db->query("SELECT * FROM conductores WHERE vlicenciaF < '".$fechax."' or vvmtF < '".$fechax."' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Ver</th>
                    <th class="th-sm">Eliminar</th>
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
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="213"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encuentra ning&uacuten conductor con documentos vencidos","success");
          } $a->close();  

  }






} // Termina la lcase