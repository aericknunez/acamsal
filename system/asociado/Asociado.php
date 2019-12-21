<?php 
class Asociados {

		public function __construct() { 
     	} 



  public function AddAsociado($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $hashed = Helpers::HashId(); // para que este hash mismo sea para cliente
                $datos["nombre"] = strtoupper($datos["nombre"]);
                $datos["hash"] = $hashed;
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("asociados", $datos)) {

                    /// agregando como cliente
                    unset($datos["edo"]);
                    $db->insert("clientes", $datos);

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerAsociados();
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

  public function UpAsociado($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $data["nombre"] = strtoupper($datos["nombre"]);
              $data["documento"] = $datos["documento"];
              $data["telefono"] = $datos["telefono"];
              $data["direccion"] = $datos["direccion"];
              $data["departamento"] = $datos["departamento"];
              $data["municipio"] = $datos["municipio"];
              $data["email"] = $datos["email"];
              $data["comentarios"] = $datos["comentarios"];
              $data["time"] = Helpers::TimeId();
              $hash = $datos["hash"];
              if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  
                  Helpers::UpdateId("clientes", $data, "hash = '$hash' and td = ".$_SESSION["td"]."");

                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?asociadover"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerAsociados(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados WHERE edo != 0 and td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Direccion</th>
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
                      <td>'.$b["direccion"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="185"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?asociadover" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelAsociado($hash){ // elimina precio
    $db = new dbConn();

        $data["edo"] = 0;
        if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")){
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerAsociados();
  }

  public function DelAsociadox($hash){ // elimina precio
    $db = new dbConn();
        
        $data["edo"] = 0;
        if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")){
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosAsociados();
  }



  public function VerTodosAsociados(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados WHERE edo != 0 and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Ver</th>
                    <th>OP</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                if($b["edo"] == 1) $edo = "Activo"; else $edo = "Inactivo";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.$edo.'</td>
                      <td><a id="xver" op="188" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="186"><i class="fa fa-minus-circle fa-lg red-text"></i></a>
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
                    <th>Ver</th>
                    <th>OP</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }











  public function VistaAsociado($data){
      $db = new dbConn();
     if ($r = $db->select("*", "asociados", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 

      if($this->CuotasPendientes($data["key"]) > 0){
        Alerts::Mensajex("ATENCI&OacuteN: Este asociado tiene ".$this->CuotasPendientes($data["key"])." cuotas pendientes","danger");
      }

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
                    <td>Departamento: '.$r["departamento"].'</td>
                    <td>Municipio: '.$r["municipio"].'</td>
                  </tr>
                  <tr>
                    <td>Email: '.$r["email"].'</td>
                    <td>Telefono: '.$r["telefono"].'</td>
                  </tr>
                  <tr>
                    <td>Contacto: '.$r["contacto"].'</td>
                    <td>Comentarios: '.$r["comentarios"].'</td>
                  </tr>
                </tbody>
              </table>'; 

        }  unset($r); 

$this->VerUnidades($data["key"], 1);


   $a = $db->query("SELECT * FROM ticket_cliente WHERE cliente = '".$data["key"]."' and td = ".$_SESSION["td"]."");
              $cf = $a->num_rows;
              $a->close();
              if($cf > 0){
                  echo '<ul class="list-group">
                        <li class="list-group-item list-group-item-secondary">Facturas Asignadas</li>';
                     echo '<li class="list-group-item d-flex justify-content-between align-items-center">Facturas 
                     <span class="badge badge-primary badge-pill">'.Helpers::Format($cf).'</span></li>';
                  echo '</ul>';
              } else {
                Alerts::Mensajex("No hay facturas asignadas","warning",$boton,$boton2);
              }


   $a = $db->query("SELECT * FROM creditos WHERE hash_cliente = '".$data["key"]."' and td = ".$_SESSION["td"]."");
              $cas = $a->num_rows;
              $a->close();
              if($cas > 0){
                  echo '<ul class="list-group">
                        <li class="list-group-item list-group-item-secondary">Creditos Asignados</li>';
                     echo '<li class="list-group-item d-flex justify-content-between align-items-center">Creditos  
                     <span class="badge badge-secondary badge-pill">'.Helpers::Format($cas).'</span></li>';
                  echo '</ul>';
              } else {
                Alerts::Mensajex("No hay creditos asignados","info",$boton,$boton2);
              }



  }





////////////////////unidades de los asociados ////
///
  public function AddUnidades($datos){
    $db = new dbConn();
      if($datos["unidad"] != NULL or $datos["placa"] != NULL){ // comprueba si todos los datos requeridos estan llenos
                $datos["edo"] = 1;
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("asociados_unidades", $datos)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerUnidades($datos["asociado"]);

  }






  public function VerUnidades($asociado, $ver = NULL){
      $db = new dbConn();

          $a = $db->query("SELECT * FROM asociados_unidades WHERE asociado='".$asociado."' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
          Alerts::Mensajex("Unidades registradas por el asociado","info");

        echo '<table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Unidad</th>
                  <th scope="col">Placa</th>';
                        if($ver == NULL){
                          echo '<th scope="col">Borrar</th>';
                        }
                  echo '</tr>
              </thead>
              <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                        <th scope="row">'.$n++.'</th>
                        <td>'.$b["unidad"].'</td>
                        <td>'.$b["placa"].'</td>';
                        if($ver == NULL){
                          echo '<td><a id="delunidad" hash="'.$b["hash"].'" op="197" asociado="'.$asociado.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                        }
                    echo '</tr>';          
              }
        echo '</tbody>
              </table>';

          } else {
             Alerts::Mensajex("No hay Unidades registradas por el asociado","danger");
          }$a->close();  

  }


  public function DelUnidad($hash, $asociado){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("asociados_unidades", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Unidad eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
     $this->VerUnidades($asociado);
  }



public function VerTodasLasUnidades(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados_unidades WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Unidad</th>
                    <th>Placa</th>
                    <th>Ver</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["unidad"].'</td>
                      <td>'.$b["placa"].'</td>
                      <td><a id="xver" op="188" key="'.$b["asociado"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Unidad</th>
                    <th>Placa</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }

  public function AsociadoNombre($hash){
      $db = new dbConn();

    if ($r = $db->select("nombre", "asociados", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 
        return $r["nombre"];
    }  unset($r);  
  }


  public function CalculaTotal($hash){
      $db = new dbConn();

    if ($r = $db->select("*", "asoc_cuotas", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 

      if($r["finF"] < Fechas::Format(date("d-m-Y"))){
        $total = $r["cuota"] + $r["mora"];
      } else {
        $total = $r["cuota"];
      }
    }  unset($r);  

    return $total;
  }




public function VerCuotas(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asoc_cuotas WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contribuci&oacuten</th>
                    <th>Cuota</th>
                    <th>Mora</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                if($b["edo"] == 1) $edo = '<a id="pagar" op="199" hash="'.$b["hash"].'"><i class="fas fa-money-bill-alt fa-lg green-text"></i> COBRAR</a>'; else $edo = "CANCELADO";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cuota"].'</td>
                      <td>'.$b["mora"].'</td>
                      <td>'.Helpers::Dinero($this->CalculaTotal($b["hash"])).'</td>
                      <td id="idcuota'.$b["hash"].'">'.$edo.'</td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contribuci&oacuten</th>
                    <th>Cuota</th>
                    <th>Mora</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }


public function Cuota($hash){
      $db = new dbConn();
        if ($r = $db->select("*", "asoc_cuotas", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 

         echo '<div class="text-center"><h4>'.$r["descripcion"].'</h4>
          <h1>'.Helpers::Dinero($this->CalculaTotal($hash)).'</h1>
          <p>Cuota de: '.Fechas::MesEscrito($r["inicio"]).' de '.Fechas::AnoFecha($r["inicio"]).'</p>
          <a id="cobrar" hash="'.$hash.'" op="200" total="'.$this->CalculaTotal($hash).'" class="btn btn-success btn-rounded">Cobrar</a>
          </div>';

        }  unset($r); 
    }

public function Cobrar($hash, $total){
      $db = new dbConn();

    $data = array();
    $data["total"] = $total;
    $data["dia_cancel"] = date("d-m-Y");
    $data["dia_cancelF"] = Fechas::Format(date("d-m-Y"));
    $data["edo"] = 2;
    $data["time"] = Helpers::TimeId();
    if (Helpers::UpdateId("asoc_cuotas", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
        Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");        

      } else {
      Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  

    }




public function CuotasPendientes($asociado){
      $db = new dbConn();

        $aw = $db->query("SELECT * FROM asoc_cuotas WHERE asociado = '".$asociado."' and finF < '".Fechas::Format(date("d-m-Y"))."' and edo = 1 and td = ".$_SESSION["td"]."");
        return $aw->num_rows;
        $aw->close();
    }




public function VerCuotasPendientes(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asoc_cuotas WHERE edo = 1 and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-striped" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contribuci&oacuten</th>
                    <th>Fecha</th>
                    <th>Cuota</th>
                    <th>Mora</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                if($b["edo"] == 1) $edo = '<a id="pagar" op="199" hash="'.$b["hash"].'">PENDIENTE</a>'; else $edo = "CANCELADO";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.Fechas::MesEscrito($b["inicio"]).' de '.Fechas::AnoFecha($b["inicio"]).'</td>
                      <td>'.$b["cuota"].'</td>
                      <td>'.$b["mora"].'</td>
                      <td>'.Helpers::Dinero($this->CalculaTotal($b["hash"])).'</td>
                      <td id="idcuota'.$b["hash"].'">'.$edo.'</td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contribuci&oacuten</th>
                    <th>Cuota</th>
                    <th>Mora</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
              </table>';


          } else {
            Alerts::Mensajex("No se encuentran cuotas pendientes a cancelar","success");
          } $a->close();  

  }





} // Termina la clase