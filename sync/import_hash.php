<?php
date_default_timezone_set('America/El_Salvador');

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "superpol_erick"); 			// The database username. 
define("PASSWORD", "caca007125-"); 	// The database password. 
define("DATABASE", "superpol_pizto");  

require_once("/home/superpol/public_html/pizto.com/login/application/common/Mysqli.php");
$db = new dbConn();



// busca todos los archivos en el directorio
$archivos = glob("/home/superpol/public_html/pizto.com/login/sync/database/*.sql");  
  foreach($archivos as $data){ 

  	$data = str_replace("/home/superpol/public_html/pizto.com/login/sync/database/", "", $data);
  	$hash = str_replace(".sql", "", $data);

    $archx = "/home/superpol/public_html/pizto.com/login/sync/database/" . $data;            


		// si no es sincronizacion lo ejecuto siempre
			if (file_exists($archx)) {
		    $sql = explode(";",file_get_contents($archx));//
			foreach($sql as $query){
			@$db->query($query);
			} @unlink($archx); } 


} // termina busqueda de archivos en la carpeta