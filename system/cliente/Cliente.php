<?php 
class Clientes {

		public function __construct() { 
     	} 



  public function AddCliente($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["nombre"] = strtoupper($datos["nombre"]);
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("clientes", $datos)) {

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerClientes();
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

  public function UpCliente($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $datos["nombre"] = strtoupper($datos["nombre"]);
              $datos["time"] = Helpers::TimeId();
              $hash = $datos["hash"];
              if (Helpers::UpdateId("clientes", $datos, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?clientever"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerClientes(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM clientes WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
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
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="65"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?clientever" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelCliente($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("clientes", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Cliente eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerClientes();
  }

  public function DelClientex($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("clientes", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Cliente eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosClientes();
  }


  public function VerTodosClientes(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM clientes WHERE td = ".$_SESSION["td"]." order by id desc");
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
                      <td><a id="xver" op="68" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="66"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
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




////////////nuevo documento factura
  public function NuevoDocumento($datos){
    $db = new dbConn();
    if($this->VerificaDocumento($datos["documento"]) > 0){
        Alerts::Alerta("error","Error!","Ya se encuentra registro de este documento!");
    } else {
      if($datos["documento"] != NULL or $datos["cliente"] != NULL){ // comprueba datos

        $datos["cliente"] = strtoupper($datos["cliente"]); // paso a mayusculas

                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("facturar_documento", $datos)) {

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  

                            $_SESSION["factura_cliente"] = $datos["cliente"];
                            $_SESSION["factura_documento"] = $datos["documento"];
                              
                              $texto = $_SESSION['config_nombre_documento']. ": " . $_SESSION["factura_documento"] . "<br> Cliente: " . $_SESSION["factura_cliente"];
                            Alerts::Mensajex($texto,"danger",'<a id="quitar-documento" op="102" class="btn btn-danger btn-rounded">Quitar '.$_SESSION["config_nombre_documento"].'</a>',$boton2);
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
  }

  }

/// verifica que no exista el numero de documento
  public function VerificaDocumento($documento){ // productde  de la tabla ticket
    $db = new dbConn();

    $a = $db->query("SELECT * FROM facturar_documento WHERE documento = '$documento' and td = ".$_SESSION["td"]."");      
        return $a->num_rows;
        $a->close();
    }







  public function VistaCliente($data){
      $db = new dbConn();
     if ($r = $db->select("*", "clientes", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 

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









} // Termina la lcase