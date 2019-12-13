<?php 
class Controles{

		public function __construct() { 
     	} 


	public function Clave(){
			$numero = sha1(Fechas::Format(date("d-m-Y")));
			$num = substr("$numero", 0, 6);
			 return $num;
	}

	public function TotalProductos(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM producto WHERE td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		     return $b["sum(cantidad)"];
		    } $a->close();
	}







} // Termina la lcase