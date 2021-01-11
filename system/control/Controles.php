<?php 
class Controles{

		public function __construct() { 
     	} 


	public function Clave(){
			$numero = sha1(Fechas::Format(date("d-m-Y")));
			$num = substr("$numero", 0, 6);
			 return $num;
	}

	public function TotalProductos(){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM producto WHERE td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		     return $b["sum(cantidad)"];
		    } $a->close();
	}


	public function CreditoPendiente(){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT sum(abono) FROM creditos_abonos WHERE edo = 1 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		    $abonos = $b["sum(abono)"];
		} $a->close();

	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 3 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		    $creditos = $b["sum(total)"];
		} $a->close();

		return 	$creditos - $abonos;

	}






	public function NoCuotas($fecha){ /// total de productos registrados
		$db = new dbConn();

	    $a = $db->query("SELECT * FROM asoc_cuotas WHERE edo = 2 and dia_cancel = '$fecha' and td = ".$_SESSION["td"]."");
	    $nocreditos = $a->num_rows;
		 $a->close();

		return 	$nocreditos;

	}




	public function CuotasPagadas($fecha){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM asoc_cuotas WHERE edo = 1 and dia_cancel = '$fecha' and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		    $cuotas = $b["sum(total)"];
		} $a->close();


		return 	$cuotas;

	}










} // Termina la lcase