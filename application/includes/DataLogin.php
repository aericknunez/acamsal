<?php 
class Login {

// verificar que los form no vengan vacios (validarlos)
/// verificar email
/// verificar password
/// sanear el formulario
/// comparar pass
///  comprobas que no exita email
///  crear password con sal
///  insertar en la BD

	public function Register($data){
	    $db = new dbConn();
		if($this->CompararPass($data["password"], $data["confirmpwd"]) == TRUE){


					$email = $this->ValidaEmail($data["email"]);
					$password = $this->ValidaPass($data["password"]);

			if($email != FALSE and $password != FALSE){
				if($this->VerificarEmail($data["email"]) == TRUE){
					$sal = $this->NuevaSal();
					$passconsal = $this->SalarPass($password, $sal);
					$user = $this->NewUser();


					$dato = array();
				    $dato["username"] = $user;
				    $dato["email"] = $email;
				    $dato["password"] = $passconsal;
				    $dato["salt"] = $sal;
				    if ($db->insert("login_members", $dato)) {

				    		$usuario = sha1($user);
				    		$datos = array();
						    $datos["nombre"] = $data["nombre"];
						    $datos["tipo"] = $data["tipo"];
						    $datos["user"] = $usuario;
						    $datos["tkn"] = 1;
						    $datos["avatar"] = "1.png";
						    $datos["td"] = $_SESSION['td'];
						    if ($db->insert("login_userdata", $datos)) {

					        Alerts::Alerta("success","Agregado!","Agregado con Exito!");
					        	if($data["inicio"] != NULL){
										echo '<a href="?" class="btn btn-danger btn-rounded  z-depth-0  waves-effect">Iniciar Sesión Aqui</a>';
									}
							}

				   	}
				   } else {
				   	Alerts::Alerta("error","Error!","Email ya esta vinculado a otra cuenta!");
				   }
					 
			} else {
				Alerts::Alerta("error","Error!","Faltan Datos");
			}
		}

	}




	public function ValidaEmail($email) {
			if($email != NULL){
			    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    			$email = filter_var($email, FILTER_VALIDATE_EMAIL);

    			    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				        return $email;
				    } else {
				    	return FALSE;
				    }

			} else {
				return FALSE;
			}
	}

	public function ValidaPass($password) {
		if($password != NULL){	
			$password = hash('sha512', $password);
			if (strlen($password) == 128) {
				return $password;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}


	public function NuevaSal() {
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        	return $random_salt;
	}


	public function SalarPass($password, $random_salt) {
        	$password = hash('sha512', $password . $random_salt);
        	return $password;
	}


	public  function NewUser(){
	  $id = $_SESSION["td"] . "-" . date("d-m-Y-H:i:s") . rand(1,999999999);
	  $iden = sha1($id);
	  $hash = substr($iden,0,6);
	  return $hash;
	}



public function VerificarEmail($email){
		$db = new dbConn();
		// verifico si esta el usuario con este pass en la bd
       $a = $db->query("SELECT email FROM login_members WHERE email = '$email'");
		if($a->num_rows == 1){
			return FALSE; // existe
        } else {
        	return TRUE; // No existe
        }	
	$a->close();
}


	public function CambiarPass($password) {
			$db = new dbConn();

			$password = hash('sha512', $password);

			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        	$password = hash('sha512', $password . $random_salt);

        	if (strlen($password) == 128) {
	        	$cambio = array();
			    $cambio["password"] = $password;
			    $cambio["salt"] = $random_salt;
			    if ($db->update("login_members", $cambio, "WHERE username = '".$_SESSION["username"]."'")) {

			    	Alerts::Alerta("success","Password Cambiado","Pasword cambiado correctamente!");
			    }
			    else {
			    	Alerts::Alerta("error","Error!","Error! no se ha podido cambiar");
			    }
        	}
        	else{
        		Alerts::Alerta("error","Error!","Error desconocido!");
        	}

	}


	public function CompararPass($pass1, $pass2) {
		if($pass1 == $pass2){
			if(strlen($pass1) > 6){
				if($this->MayusCount($pass1) > 0) {
					if($this->NumCount($pass1) > 0) {
						return TRUE;
					} else { Alerts::Alerta("error","Error!","Debe contener al menos un numero"); } 
					
				} else { Alerts::Alerta("error","Error!","Debe tener al manos una Mayuscula");  }
				
			}
			else { Alerts::Alerta("error","Error!","El password debe tener mas de 6 Caracteres"); }
			
		} else { Alerts::Alerta("error","Error!","Los password no son iguales"); }

	}


	public function MayusCount($string){
	    $string = preg_match_all('/([A-Z]{1})/',$string,$foo);
	    return $string;
	}


	public function NumCount($string){
	    $string = preg_match_all('/([0-9]{1})/',$string,$foo);
	    return $string;
	}

///////////////// funciones
 public function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name 
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
       Alerts::Alerta("error","Error!","No se puede Iniciar"); 
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}




 public function checkbrute($user_id) {
    $db = new dbConn();

    $now = time();

    // verifico en 2 horas
    $valid_attempts = $now - (2 * 60 * 60);

    $a = $db->query("SELECT time FROM login_attempts WHERE user_id = '$user_id' AND time > '$valid_attempts'");
	$intentos = $a->num_rows;

	    if ($intentos > 5) {
            return FALSE; // hay fuerza
        } else {
            return TRUE; // no hay fuerza
        }

	$a->close();
}




 public function LogOn($email, $password){
    $db = new dbConn();
// consulto si existe el registro del email
    $a = $db->query("SELECT * FROM login_members WHERE email = '$email'");
    if($a->num_rows > 0){
    	    foreach ($a as $b) {
		        $user_id = $b["id"]; $pass_db = $b["password"]; $sal = $b["salt"]; $username = $b["username"];
		    }
		    /// aqui van las funciones
		    $password = $this->SalarPass($password, $sal);
		    // revisar fuerza bruta
		    if($this->checkbrute($user_id) == TRUE){ // no hay fuerza bruta
		    	// comparo si el pass form es igual al de  la bd
		    	if($password == $pass_db){
                    
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

		    		return TRUE;
		    	} else { // registro fuerza bruta
		    		$now = time();
		    		    $datox = array();
					    $datox["user_id"] = $user_id;
					    $datox["time"] = $now;
					    $db->insert("login_attempts", $datox); 
		    		return FALSE;
		    	}

		    }else { // fuerza bruta la cuenta esta bloqueada
		    	return FALSE;
		    }
		} else {
			Alerts::Alerta("error","Error!","Error en la Base de datos"); 
		}

    
    $a->close();


}





 public function login_check(){
     $db = new dbConn();
    // Verificar si estan las variables
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];


        // verifico si esta el usuario con este pass en la bd
       $a = $db->query("SELECT password FROM login_members WHERE id = '$user_id'");
		if($a->num_rows == 1){
			    foreach ($a as $b) {
			       $password = $b["password"];
			    }
			$login_check = hash('sha512', $password . $user_browser);

			if ($login_check == $login_string) {
				
                    return TRUE; // login
                } else { 
                    return FALSE; // No login
                }
		} else { 
            return FALSE; // No login
        }
	
	$a->close();


    } else {
        // No hay variables de session 
        return FALSE;
    }
}

















} // termina la clase