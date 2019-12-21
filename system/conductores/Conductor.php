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
                    <th class="th-sm">Detalles</th>
                    <th class="th-sm">OP</th>
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
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="213"><i class="fa fa-minus-circle fa-lg red-text"></i></a>
                      <a id="print" hash="'.$b["hash"].'" op="186"><i class="fa fa-print fa-lg blue-text"></i></a></td>
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
                    <th>OP</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }





  public function VistaConductor($data){
      $db = new dbConn();
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
                  <li class="list-group-item d-flex justify-content-between align-items-center"><span> Vencimineto: </span> <span class="pro-detail">'.$r["vlicencia"].'</span></li>
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

        }  unset($r); 


  }






  public function Vencidos(){
      $db = new dbConn();

        $fechax = Fechas::Format(date("d-m-Y")) + 1296000;

          $a = $db->query("SELECT * FROM conductores WHERE vlicenciaF < '".$fechax."' or vvmtF < '".$fechax."' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
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










} // Termina la lcase