<?php 
class Usuarios{
	public $password;
	public $pass1;
	public $pass2;


	function ActualizarUsuario($nombre,$tipo,$user){
	    $db = new dbConn();

	    	    $cambio = array();
			    $cambio["nombre"] = $nombre;
			    $cambio["tipo"] = $tipo;
			    if ($db->update("login_userdata", $cambio, "WHERE user='$user'")) {
			    Alerts::Alerta("success","Actualizado","Usuario Actualizado");
			    } else {
			    Alerts::Alerta("error","Error!","Error al actualizar!");
			    }

	}


	function CambiarAvatar($avatar,$user){
	    $db = new dbConn();

	    	    $cambio = array();
			    $cambio["avatar"] = $avatar;
			    if ($db->update("login_userdata", $cambio, "WHERE user='$user'")) {
			    Alerts::Alerta("success","Actualizado","Usuario Actualizado");
			    echo '<img src="assets/img/avatar/'.$avatar.'" class="img-fluid rounded-circle hoverable mx-auto d-block" alt="alt="avatar mx-auto white">';
			     
			     if($_SESSION["user"] == $user) { $_SESSION["avatar"] = $avatar; }

			    } else {
			    Alerts::Alerta("error","Error!","Error al actualizar!");
			    }

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
						$this->CambiarPass($pass1);
					} else { echo "Debe contener al menos un numero"; } 
					
				} else {
					echo "Debe tener al manos una Mayuscula";
				}

				
			}
			else { 
				echo "El password debe tener mas de 6 Caracteres";
			}
			
		} else {
			echo "Los password no son iguales";
		}

	}

	function MayusCount($string){
	    $string = preg_match_all('/([A-Z]{1})/',$string,$foo);
	    return $string;
	}


	function NumCount($string){
	    $string = preg_match_all('/([0-9]{1})/',$string,$foo);
	    return $string;
	}



	public function EliminarUsuario($iden, $username) {
			$db = new dbConn();
			
			if ( $db->delete("login_members", "WHERE id='$iden'")) {
        	
        		if ( $db->delete("login_userdata", "WHERE user='$username'")) {
	        	
	        	$this->VerUsuarios();
	     		Alerts::Alerta("success","Usuario Eliminado","Usuario eliminado correctamente! Inicie nuevamente");
	    		} 
    		} 
	}


	public function VerUsuarios(){
	$db = new dbConn();

	$a = $db->query("SELECT * FROM login_members WHERE id != 1");
	if($a->num_rows > 0){
		echo '<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col">Nombre </th>
			      <th scope="col" class="d-none d-md-block">Email</th>
			      <th scope="col">Cuenta</th>
			      <th scope="col">Eliminar</th>
			      <th scope="col">Editar</th>
			      <th scope="col">Avatar</th>
			    </tr>
			  </thead>
			  <tbody>';
	}
    foreach ($a as $b) {
    	$user=sha1($b["username"]);
    	
    	if ($r = $db->select("*", "login_userdata", "WHERE user = '$user'")) { 
       	$nombre = $r["nombre"]; $tipo = $r["tipo"];
    	} unset($r); 




    	if(($_SESSION["user"] == $user) or ($_SESSION["tipo_cuenta"]!= 5)){

    	echo '<tr>';
		
		echo '<th scope="row">'.$nombre.'</th>
		      <td class="d-none d-md-block">'.$b["email"].'</td>
		      <td>'.Helpers::UserName($tipo).'</td>';

			if($_SESSION["user"] == $user or $_SESSION["tipo_cuenta"] == 1  or $_SESSION["tipo_cuenta"] == 2){
				echo '<td><a id="deluser" op="5" iden="'.$b["id"].'" username="'.$user.'" ><i class="fa fa-trash red-text fa-lg"></i></a></td>';
			} else {
				echo '<td><a><i class="fa fa-trash grey-text  fa-lg"></i></a></td>';
			}

			if($_SESSION["user"] == $user or $_SESSION["tipo_cuenta"] == 1  or $_SESSION["tipo_cuenta"] == 2){
				echo '<td><a href="?modal=newpass&user='.$b["username"].'&op=actualizar"><i class="fa fa-unlock-alt red-text fa-lg"></i></a>
				<a href="?modal=userupdate&user='.$b["username"].'&op=actualizar"><i class="fa fa-edit red-text fa-lg"></i></a></td>';
			} else {
				echo '<td><a ><i class="fa fa-unlock-alt grey-text fa-lg"></i></a>
				<a ><i class="fa fa-edit grey-text fa-lg"></i></a></td>';
			}

			if($_SESSION["user"] == $user or $_SESSION["tipo_cuenta"] == 1  or $_SESSION["tipo_cuenta"] == 2){
				echo '<td><a href="?modal=avatar&user='.$b["username"].'" ><i class="fa fa-user red-text fa-lg"></i></a></td>';
			} else {
				echo '<td><a ><i class="fa fa-user grey-text fa-lg"></i></a></td>';
			}

		echo '</tr>';  
	}


    } $a->close();
    echo '</tbody>
		</table>';


	}






}