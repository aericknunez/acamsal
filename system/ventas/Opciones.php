<?php 
class Opciones{

	public function __construct() { 
 	} 



 	public function AddCredito(){
 		$db = new dbConn();

 			$datos = array();
		    $datos["hash_cliente"] = $_SESSION["cliente_c"];
		    $datos["nombre"] = $_SESSION["cliente_credito"];
		    $datos["factura"] = NULL;
		    $datos["orden"] = $_SESSION["orden"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["edo"] = 1;
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("creditos", $datos); 

 	}

 	public function ConfirmCredito($factura, $cliente){
 		$db = new dbConn();
	   	$cambios = array();
	   	$cambios["factura"] = $factura;
	   	Helpers::UpdateId("creditos", $cambios, "hash_cliente = '".$cliente."' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 	

	   	$this->ConfirmCliente($factura, $cliente);	
 	}	

 	public function DelCredito(){
 		$db = new dbConn();

		Helpers::DeleteId("creditos", "orden = ".$_SESSION["orden"]." and hash_cliente = '".$_SESSION["cliente_c"]."' and td = ".$_SESSION["td"]."");
		Helpers::DeleteId("ticket_cliente", "orden = ".$_SESSION["orden"]." and cliente = '".$_SESSION["cliente_cli"]."' and td = ".$_SESSION["td"]."");

		$cambio = array();
	    $cambio["nombre"] = NULL;
	    Helpers::UpdateId("ticket_orden", $cambio, "correlativo = '".$_SESSION["orden"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

		$this->UnsetCredito();
		$this->UnsetCliente();
 	}


 	public function UnsetCredito(){
 			if(isset($_SESSION["cliente_c"])) unset($_SESSION["cliente_c"]);
			if(isset($_SESSION["cliente_credito"])) unset($_SESSION["cliente_credito"]);		
 	}


 	public function VarCredito(){
 		$db = new dbConn();

    if ($r = $db->select("hash_cliente, nombre", "creditos", "WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 

    	if($r["hash_cliente"] != NULL){
    		$_SESSION["cliente_c"] =  $r["hash_cliente"];
        	$_SESSION["cliente_credito"] =  $r["nombre"];
    	}
    	 
    } unset($r);  

    $this->VarCliente();
 	}

/////////////
///
///
///
////////////
 	public function AddCliente(){
 		$db = new dbConn();

 			$datos = array();
		    $datos["factura"] = NULL;
		    $datos["orden"] = $_SESSION["orden"];
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["cliente"] = $_SESSION["cliente_cli"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_cliente", $datos); 
 	}


 	public function ConfirmCliente($factura, $cliente){
 		$db = new dbConn();
	   	$cambios = array();
	   	$cambios["factura"] = $factura;
	   	Helpers::UpdateId("ticket_cliente", $cambios, "cliente = '".$cliente."' and orden = ".$_SESSION["orden"]." and td = ".$_SESSION["td"].""); 		
 	}	


 	public function DelCliente(){
 		$db = new dbConn();

		Helpers::DeleteId("ticket_cliente", "orden = ".$_SESSION["orden"]." and cliente = '".$_SESSION["cliente_c"]."' and td = ".$_SESSION["td"]."");
		$this->UnsetCliente();

		$cambio = array();
	    $cambio["nombre"] = NULL;
	    Helpers::UpdateId("ticket_orden", $cambio, "correlativo = '".$_SESSION["orden"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  
	    
 	}


 	public function UnsetCliente(){
			if(isset($_SESSION["cliente_cli"])) unset($_SESSION["cliente_cli"]);
			if(isset($_SESSION["cliente_asig"])) unset($_SESSION["cliente_asig"]);		
 	}


 	public function VarCliente(){
 		$db = new dbConn();

	    if ($r = $db->select("cliente", "ticket_cliente", "WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
	    	if($r["cliente"] != NULL){
	    		$_SESSION["cliente_cli"] =  $r["cliente"];
	    	}	    	
	    } unset($r);  


	    if ($r = $db->select("nombre", "clientes", "WHERE hash = '".$_SESSION["cliente_cli"]."' and td = ".$_SESSION["td"]."")) { 
	    		if($r["nombre"] != NULL){
	    			$_SESSION["cliente_asig"] =  $r["nombre"];
	    		}	    	
	    } unset($r);  

 	}




} // termina clase