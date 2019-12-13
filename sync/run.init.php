<?php

$enlace = mysql_connect('localhost', 'root', 'erick');


$sql = 'CREATE DATABASE IF NOT EXISTS cozto_ventas';
mysql_query($sql, $enlace);


include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/common/Mysqli.php';
include_once '../application/includes/DataLogin.php';


$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();



$archivo = "cozto_ventas.sql";
// si no es sincronizacion lo ejecuto siempre
	if (file_exists($archivo)) {
		    $sql = explode(";",file_get_contents($archivo));//
			
			foreach($sql as $query){
				@$db->query($query);
			}  @unlink($archivo);
	} 
