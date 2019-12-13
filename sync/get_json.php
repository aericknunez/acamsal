<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/common/Mysqli.php';
include_once '../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();
include_once '../application/common/Fechas.php';


$fecha = date("d-m-Y");
$hora = date("H:i:s");

    if ($r = $db->select("td", "config_root", "WHERE id = 1")) { 
        $_SESSION["temporal_td"] = $r["td"];
    } unset($r);  



$data =  file_get_contents('https://pizto.com/login/application/includes/db_sync_json.php?x=' . $_SESSION["temporal_td"]); 
$datos = json_decode($data, true);

foreach ($datos as $valores) { // vamos hacer un archivo por cada hash
	$sync = $valores["hash"];

$a = $db->query("SELECT * FROM login_db_sync WHERE hash = '$sync'");
if($a->num_rows == 0){

	$handle = fopen($sync . ".sql",'w+');
	$resultado.= 'INSERT INTO login_sync VALUES("", "'.$sync.'", "4", "1",  "'.$fecha.'", "'.$hora.'", "'.$_SESSION["temporal_td"].'");';
	
	fwrite($handle,$resultado);
	unset($resultado);
	fclose($handle);

	$dato = array();
	$dato["hash"] = $sync;
	$dato["fecha"] = $fecha;
	$dato["hora"] = $hora;
	$datos["hash"] = Helpers::HashId();
	$datos["time"] = Helpers::TimeId();
	$db->insert("login_db_sync", $dato);

// aqui ejecuto el sql que deberia estar en el directorio descargado de git
$archx = "sql/" . $sync . ".sql";            

if (file_exists($archx)) {
$sql = explode(";",file_get_contents($archx));//
foreach($sql as $query){
@$db->query($query);
} @unlink($archx); } 

//
	} $a->close();


	if($sync != NULL){
		if(SubirFtp($sync) == TRUE){
			@unlink($sync . ".sql");	
		}	 
	} 


} // foreach


function SubirFtp($sync){
	include_once '../system/sync/Ftp.php';
		$subir =  new Ftp;
		if($subir->Servidor("ftp.pizto.com",
						"erick@pizto.com",
						"caca007125-",
						$sync,
						"/admin/sync/database/",
						"C:/AppServ/www/pizto/sync/". $sync .".sql") == TRUE){
						return TRUE;
		} else {
			return FALSE;
		}
}




///////// actualizar el root
$data =  file_get_contents('https://pizto.com/login/application/includes/root_json.php?x=' . $_SESSION["temporal_td"]); 
$cambio = json_decode($data, true);
Helpers::UpdateId("config_root", $cambio, "td=" . $_SESSION["temporal_td"]);

unset($_SESSION["temporal_td"]);
