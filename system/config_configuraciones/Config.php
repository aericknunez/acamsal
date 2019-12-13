<?php 
class Config{

	public function __construct() { 
     } 


	public function Configuraciones($sistema,$cliente,$slogan,$propietario,$telefono,$direccion,$email,$pais,$giro,$nit,$imp,$nombre_impuesto,$nombre_documento,$moneda,$moneda_simbolo,$tipo_inicio,$skin,$inicio_tx,$otras_ventas,$cambio_tx){
		$db = new dbConn();

		$cambio = array();
	    $cambio["sistema"] = $sistema;
	    $cambio["cliente"] = $cliente;
	    $cambio["slogan"] = $slogan;
	    $cambio["propietario"] = $propietario;
	    $cambio["telefono"] = $telefono;
	    $cambio["direccion"] = $direccion;
	    $cambio["email"] = $email;
	    $cambio["pais"] = $pais;
	    $cambio["giro"] = $giro;
	    $cambio["nit"] = $nit;
	    $cambio["imp"] = $imp;
	    $cambio["nombre_impuesto"] = $nombre_impuesto;
	    $cambio["nombre_documento"] = $nombre_documento;
	    $cambio["moneda"] = $moneda;
	    $cambio["moneda_simbolo"] = $moneda_simbolo;
	    $cambio["tipo_inicio"] = $tipo_inicio;
	    $cambio["skin"] = $skin;
	    $cambio["inicio_tx"] = $inicio_tx;
	    $cambio["otras_ventas"] = $otras_ventas;
	    $cambio["cambio_tx"] = $cambio_tx;
	    $cambio["time"] = Helpers::TimeId();
	    if (Helpers::UpdateId("config_master", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}



	public function Root($expira,$expiracion,$ftp_servidor,$ftp_path,$ftp_ruta,$ftp_user,$ftp_password,$tipo_sistema,$plataforma){
		$db = new dbConn();

		$cambio = array();
	    $cambio["expira"] = $expira;
	    $cambio["expiracion"] = $expiracion;
	    $cambio["ftp_servidor"] = $ftp_servidor;
	    $cambio["ftp_path"] = $ftp_path;
	    $cambio["ftp_ruta"] = $ftp_ruta;
	    $cambio["ftp_user"] = $ftp_user;
	    $cambio["ftp_password"] = $ftp_password;
	    $cambio["tipo_sistema"] = $tipo_sistema;
	    $cambio["plataforma"] = $plataforma;
	    $cambio["time"] = Helpers::TimeId();
	    if (Helpers::UpdateId("config_root", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}
	


	



	public function CrearVariables(){
		$db = new dbConn();
		$encrypt = new Encrypt;

		if ($r = $db->select("*", "config_master", "WHERE td = ".$_SESSION['td']."")) { 

			$_SESSION['config_sistema'] = $r["sistema"];
			$_SESSION['config_cliente'] = $r["cliente"];
			$_SESSION['config_slogan'] = $r["slogan"];
			$_SESSION['config_propietario'] = $r["propietario"];
			$_SESSION['config_telefono'] = $r["telefono"];
			$_SESSION['config_giro'] = $r["giro"];
			$_SESSION['config_nit'] = $r["nit"];
			$_SESSION['config_imp'] = $r["imp"];
			$_SESSION['config_direccion'] = $r["direccion"];
			$_SESSION['config_email'] = $r["email"];
			$_SESSION['config_imagen'] = $r["imagen"]; // de la empresa
			$_SESSION['config_logo'] = $r["logo"]; // el de pizto
			$_SESSION['config_skin'] = $r["skin"];
			$_SESSION['tipo_inicio'] = $r["tipo_inicio"];

			$_SESSION['config_pais'] = $r["pais"];
			$_SESSION['config_moneda'] = $r["moneda"];
			$_SESSION['config_moneda_simbolo'] = $r["moneda_simbolo"];
			$_SESSION['config_nombre_impuesto'] = $r["nombre_impuesto"];
			$_SESSION['config_nombre_documento'] = $r["nombre_documento"];
			$_SESSION['tx'] = $r["inicio_tx"];
			$_SESSION['config_otras_ventas'] = $r["otras_ventas"];
			$_SESSION['config_cambio_tx'] = $r["cambio_tx"];

			if($_SESSION['config_skin'] == NULL) $_SESSION['config_skin'] = "mdb-skin";
			// white-skin , mdb-skin , grey-skin , pink-skin ,  light-blue-skin , black-skin  cyan-skin, navy-blue-skin

			// fixed-sn , hidden-sn
			} unset($r);

			    // para root pero sin descifrar
			if ($root = $db->select("*", "config_root", "WHERE td = ".$_SESSION['td']."")) {

			$_SESSION['root_expira'] = $root["expira"];
			$_SESSION['root_expiracion'] = $root["expiracion"];
			$_SESSION['root_tipo_sistema'] = $root["tipo_sistema"];
			$_SESSION['root_plataforma'] = $root["plataforma"];
     
			} unset($root);
			$_SESSION['root_tipo_sistema'] = $encrypt->Decrypt(
  			$_SESSION['root_tipo_sistema'],$_SESSION['secret_key']);

			$_SESSION['root_plataforma'] = $encrypt->Decrypt(
			$_SESSION['root_plataforma'],$_SESSION['secret_key']);

	}



	public function AddSucursal($user,$td){
		$db = new dbConn();

		    $datos = array();
		    $datos["user"] = $user;
		    $datos["sucursal"] = $td;
		    if ($db->insert("login_sucursales", $datos)) {
		    Alerts::Alerta("success","Agregado Correctamente","Usuario agregado correctamente a la sucursal");
		    } else {
		    Alerts::Alerta("danger","Error","Ocurrio un error inesperado");
		    }
		$this->CuentasSucursal($_SESSION['user']);
	}


	public function CuentasSucursal($user){
		$db = new dbConn();
	
	if($_SESSION["tipo_cuenta"] == 1 and $_SESSION["td"] != 0){ 
	 $a = $db->query("SELECT * FROM login_sucursales order by user desc");
	} else {
		$a = $db->query("SELECT * FROM login_sucursales WHERE user = '$user'");
	}

	if($a->num_rows > 0){
	 echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			    <th scope="col">Usuario</th>
			      <th scope="col">Nombre del Sistema</th>
			      <th scope="col">Pais</th>
			      <th scope="col">Corte</th>
			      <th scope="col">Venta Hoy</th>
			      <th scope="col">Ultima Actualizacion</th>
			      <th scope="col">Cambiar</th>
			    </tr>
			  </thead>
			  <tbody>';
	    foreach ($a as $b) {  
		    $r = $db->select("cliente, pais", "config_master", "WHERE td = ".$b["sucursal"]."");

		    // ultima actualizacion
	    		if ($rx = $db->select("*", "login_sync", "WHERE td = ".$b["sucursal"]." and edo = 1 order by id desc")) {
		    		$update = $rx["fecha"] . " | " . $rx["hora"];		        
		    	} unset($rx);

		    	// total venta por sucursal
		    	$fechax = date("d-m-Y");
		    $ax = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$b["sucursal"]." and fecha = '$fechax'");
		    foreach ($ax as $bx) {
		     $totalventa=$bx["sum(total)"]; } $ax->close();  

		     // busco si hubo corte
		     if ($ra = $db->select("fecha", "corte_diario", "where edo = 1 and td = ".$b["sucursal"]." order by id DESC LIMIT 1")) { $fechaultima=$ra["fecha"]; } unset($ra); 
		     if($fechaultima == date("d-m-Y")) $corte = "Realizado";
		     else $corte = "Sin corte";


	    	$userx = $b["user"];
	    	$x = $db->select("nombre", "login_userdata", "WHERE user = '$userx'");
		    echo '<tr>
		    	  <th scope="col">'.$x["nombre"].'</th>
			      <th scope="col">'.$r["cliente"].'</th>
			      <th scope="col">'.Helpers::Pais($r["pais"]).'</th>			      
			      <th scope="col">'. $corte .'</th>
			      <th scope="col">'. $r["moneda_simbolo"] . $totalventa .'</th>
			      <th scope="col">'.$update.'</th>
			      <th scope="col">';
				if($b["sucursal"] == $_SESSION['td']){
					echo '<a id="predeterminar" op="131" iden="'.$b["sucursal"].'" class="btn-sm">Predeterminar  <i class="fa fa-play red-text"></i></a>';
				} else {
					echo '<a id="irlocal" op="129" iden="'.$b["sucursal"].'" class="btn-sm">Seleccionar  <i class="fa fa-play blue-text"></i></a>';
				}
			echo '</th>
			    </tr>';
		unset($r);
		unset($x);
	    } 
	    echo '</tbody>
		    </table>';
		} else {
			echo '<h1 class="text-danger text-center">No tiene mas sucursales vinculados a su cuenta</h1>';
		}
		$a->close();

	}





	public function DefineSucursal($user,$td){
		$db = new dbConn();

		    $cambio = array();
		    $cambio["td"] = $td;
		    if ($db->update("login_userdata", $cambio, "WHERE user = '$user'")) {
			    
		   		$_SESSION['td'] = $td;
		      	$_SESSION['secret_key'] = md5($_SESSION['td']);
			  	$this->CrearVariables();
			  	echo '<script>
				window.location.href="?"
				</script>';

			    } 

		     
	}







/// para las tablas a sync


	public function VerTablas(){
		$db = new dbConn();

	$tables = $db->listTables();
    $arrlength = count($tables);

		echo '<table class="table table-sm table-striped">
	   <thead>
	     <tr>
	       <th>Nombre de la Tabla</th>
	       <th>Estado</th>
	       <th>Acci&oacuten</th>
	     </tr>
	   </thead>
	   <tbody>';
			for($x = 0; $x < $arrlength; $x++) {     
	
		echo '<tr>
		       <td>' . $tables[$x] . '</td>';
		       if($this->VerificaTabla($tables[$x]) != FALSE){
		       	if($this->VerificaTabla($tables[$x]) == 1){
		       		$color = 'fas fa-check blue-text';
		       	} else {
		       		$color = 'fas fa-ban red-text';
		       	}
		       	echo '<td>Existe</td>
		       	<td><a id="tablemod" op="13" tabla="'.$tables[$x].'" accion="2" edo="'. $this->VerificaTabla($tables[$x]). '" class="btn-floating btn-sm"><i class="'.$color.'"></i></a></td>';
		       } else {
		       	echo '<td>No existe</td>
		       	<td><a id="tablemod" op="13" tabla="'.$tables[$x].'" accion="1"  class="btn-floating btn-sm"><i class="fas fa-check-circle green-text"></i></a></td>';
		       }
		echo '</tr>';

		    } 
		echo '</tbody>
		</table>';
 
 }



	public function VerificaTabla($tabla){
		$db = new dbConn();

		$a = $db->query("SELECT edo FROM sync_tabla WHERE tabla = '$tabla' and td =  ".$_SESSION["td"]."");
		if($a->num_rows > 0){
			    foreach ($a as $b) {
		        return $b["edo"];
		    	}
		} else {
			return FALSE;
		} $a->close();
 }


	public function ModTabla($datos){
		$db = new dbConn();

		if($datos["accion"] == "1"){

			    $inserta = array();
			    $inserta["tabla"] = $datos["tabla"];
			    $inserta["edo"] = 1;
			    $inserta["hash"] = Helpers::HashId();
			    $inserta["time"] = Helpers::TimeId();
			    $inserta["td"] = $_SESSION["td"];
			    if ($db->insert("sync_tabla", $inserta)) {
			        Alerts::Alerta("success","Agregado Correctamente","Se Agrego esta tabla");
			    } 

		} else {

			if($datos["edo"] == "1"){
					    $cambio = array();
					    $cambio["edo"] = "2";
					    if (Helpers::UpdateId("sync_tabla", $cambio, "tabla='".$datos["tabla"]."'and td = ".$_SESSION["td"]."")) {
					     Alerts::Alerta("error","Cambiado Correctamente","Se Cambio el estado esta tabla a Inactivo");
					    }
			} else {
					    $cambio = array();
					    $cambio["edo"] = "1";
					    if (Helpers::UpdateId("sync_tabla", $cambio, "tabla='".$datos["tabla"]."'and td = ".$_SESSION["td"]."")) {
					     Alerts::Alerta("info","Cambiado Correctamente","Se Cambio el estado esta tabla a Activo");
					    }

			}
		}
	
	$this->VerTablas();

	}


















} // fin de la clase

 ?>