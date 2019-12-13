<?php 
class Inicio{

	public function __construct(){

	}




	public function CreaCodigos($fecha){
		$db = new dbConn();

		echo '<div class="row d-flex justify-content-center text-center text-danger p-4">
			  <div class="col-sm-4 border border-light">
				'.Encrypt::Encrypt(Fechas::Format($fecha),$_SESSION['secret_key']).'
			  </div>
			</div>';
	}


	public function RegisterInOut($edo){
		$db = new dbConn();
		    $datos = array();
		    $datos["user"] = $_SESSION['user'];
		    $datos["nombre"] = $_SESSION['nombre'];
		    $datos["accion"] = $edo;
		    $datos["ip"] = Helpers::GetIp();
		    $datos["navegador"] = $_SERVER["HTTP_USER_AGENT"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
		    $datos["hora"] = date("H:i:s");
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("login_inout", $datos); 		
	}


	public function Validar($fecha,$codigo){
		$db = new dbConn();

		if($fecha != NULL or $codigo != NULL){
			$codigo = str_replace(' ', '', $codigo); // elimina espacios

			if(Fechas::Format($fecha) == Encrypt::Decrypt($codigo,$_SESSION['secret_key'])){
				
				    $cambio = array();
				    $cambio["expira"] = Encrypt::Encrypt($fecha,$_SESSION['secret_key']);
				    $cambio["expiracion"] = $codigo;
				    if ($db->update("config_root", $cambio, "WHERE td = ".$_SESSION["td"]."")) {
				        
				        Alerts::Alerta("success","Cambios realizados","Ha introducido su codigo correctamente");
				    } else {
				    	Alerts::Alerta("warning","Ocurrio algo","Ha ocurrido un inconveniente, introduzca su codigo nuevamente");
				    }

				
			} else {
				Alerts::Alerta("error","Error","Los codigos introducidos no son correctos, asegurese de tener codigos validos");
			}
	} else {
	Alerts::Alerta("error","Error","Ha enviado datos vacios");
	}	
		$this->Caduca();
		$this->NoAcceso();
		echo '<div class="row d-flex justify-content-center text-center">
		<a href="" class="btn btn-success">Volver a Intentarlo</a></div>';

	}



	public function Caduca(){ // ver si esta caducado el sistema
        $db = new dbConn();
        $r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");
        $encrypt = new Encrypt;
        $fechas = new Fechas;


            if($_SESSION['tipo_cuenta'] != 1){ // si no es root

                $key1 = $encrypt->Decrypt($r["expira"],$_SESSION['secret_key']);
                $key2 = $encrypt->Decrypt($r["expiracion"],$_SESSION['secret_key']);
                $key1 = $fechas->Format($key1);


                    if($key1 == $key2){ // si son iguales verifico que no esten vencidas
                            $ahora = $fechas->Format(date("d-m-Y"));

                            if($ahora < $key1){ // esta bien // CADUCA 0 = bien, 1 = 5 dias, 2 = paso
                                $_SESSION["caduca"] = 0;
                            } if($ahora > $key1 - 432000 and $ahora <= $key1){ // entre los 5
                                $_SESSION["caduca"] = 1;
                            } if($ahora > $key1 and $ahora <= $key1 + 432000){ // faltan 5
                                $_SESSION["caduca"] = 2;
                            }if($ahora > $key1 + 432000){ // se paso
                                $_SESSION["caduca"] = 3;
                            } 

                        } else { //  No son iguales. de una vez las declaro invalidas
                            $_SESSION["caduca"] = 3;
                        }
            
            } else { // usuario root nunca vence
                $_SESSION["caduca"] = 0; 
            }  

            unset($r);  
       }






	public function Formulario(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>C&oacutedigo de validaci&oacuten</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-validar" name="form-validar">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <input type="text" id="codigo" name="codigo" class="form-control mb-1" placeholder="Codigo">
				    <button class="btn btn-success" type="submit" id="btn-validar" name="btn-validar">Validar</button>
				</form>

				  </div>
				</div>';
	}


	public function FormularioCodigos(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>Crear C&oacutedigos</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-codigo" name="form-codigo">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <br>
				    <button class="btn btn-success" type="submit" id="btn-codigo" name="btn-codigo">Crear Codigo</button>
				</form>

				  </div>
				</div>';
	}


	public function NoAcceso(){
		$db = new dbConn();

		$r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");

if($_SESSION["caduca"] == 0){
	echo Alerts::Mensaje("Su cuenta esta desbloqueada y activa hasta el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"success",'<a href="?" class="btn btn-info waves-effect waves-light">Continuar...</a>',NUll);
}
if($_SESSION["caduca"] == 1){
	echo Alerts::Mensaje("Su cuenta esta a punto de expirar, caduca el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"danger",'<a id="habilitar" op="130" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 2){
	echo Alerts::Mensaje("Su cuenta ha expirado desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . " Es Necesario que ingrese un codigo de activacion v&aacutelido para poder siguir usando el sistema o &eacuteste ser&aacute bloqueado. Ultima fecha para ingresar un c&oacutedigo es: ". Fechas::DiaSuma(Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']), 5).". Cualquier duda contacte al administrador.","danger",'<a id="habilitar" op="130" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 3){
	echo Alerts::Mensaje("Su cuenta ha sido Bloqueada desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . ". Para poder seguir usando el sistema debe ingresar un nuevo c&oacutedigo de activaci&oacuten v&aacutelido.","danger",'<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>',NUll);
}

 unset($r); 

	}











} // clase