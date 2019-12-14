<?php 
class Contribuciones {

		public function __construct() { 
     	} 



  public function AddContribucion($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $data["contribucion"] = strtoupper($datos["contribucion"]);
                $data["cuota"] = $datos["cuota"];
                $data["dias_activos"] = $datos["dias"];
                $data["mora"] = $datos["mora"];
                $data["inicio"] = $datos["inicio_submit"];
                $data["inicioF"] = Fechas::Format($datos["inicio_submit"]);
                $data["fin"] = Fechas::DiaSuma($datos["inicio_submit"],$datos["dias"]);
                $data["finF"] = Fechas::Format(Fechas::DiaSuma($datos["inicio_submit"],$datos["dias"])); // inicio mas dias de vig
                $data["vigencia"] = $datos["vigencia_submit"]; // del form
                $data["vigenciaF"] = Fechas::Format($datos["vigencia_submit"]);
                $data["tipo"] = $datos["tipo"];
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("asociados_contribuciones", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerContribuciones();
  }


  public function CompruebaForm($datos){
        if($datos["contribucion"] == NULL or
          $datos["cuota"] == NULL or
          $datos["dias"] == NULL or
          $datos["mora"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpContribucion($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos
                $data["contribucion"] = strtoupper($datos["contribucion"]);
                $data["cuota"] = $datos["cuota"];
                $data["mora"] = $datos["mora"];

                $data["vigencia"] = $datos["vigencia_submit"]; // del form
                $data["vigenciaF"] = Fechas::Format($datos["vigencia_submit"]);
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
              if (Helpers::UpdateId("asociados_contribuciones", $data, "hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?contribucionadd"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }

  }



  public function VerContribuciones(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados_contribuciones WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Contribuci&oacuten</th>
              <th scope="col">Cuota</th>
              <th scope="col">Mora</th>
              <th scope="col">Estado</th>
              <th scope="col">Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                if($this->EdoVigencia($b["hash"]) == TRUE) $vig = "Activo"; else $vig = "Inactivo";
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["contribucion"].'</td>
                      <td>'.$b["cuota"].'</td>
                      <td>'.$b["mora"].'</td>
                      <td>'.$vig.'</td>
                      <td><a href="?modal=editcontribucion&key='.$b["hash"].'" ><i class="fa fa-edit fa-lg green-text"></i></a><a id="xdelete" hash="'.$b["hash"].'" op="191"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
          } $a->close();  
      
  }

  public function EdoVigencia($contribucion){
      $db = new dbConn();

    if ($r = $db->select("vigenciaF", "asociados_contribuciones", "WHERE hash = '$contribucion' and td = ".$_SESSION["td"]."")) { 
        $vigencia = $r["vigenciaF"];
    }  unset($r);  

      if($vigencia == NULL or $vigencia <= Fechas::Format(date("d-m-Y"))){
        return TRUE;
      } else {
        return FALSE;
      }
  }




  public function DelContribucion($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("asociados_contribuciones", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerContribuciones();
  }








} // Termina la lcase