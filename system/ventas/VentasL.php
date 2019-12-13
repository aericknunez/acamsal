<?php 
class Ventas{

	public function __construct() { 
 	} 




   public function AddVenta($datos){ // lento
	if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  	$this->Agregar($datos);

  	$this->VerProducto();
   }



   public function SumaVenta($datos){ //  para agregar productos rapidamente

  		if($this->ObtenerCantidad($datos["cod"]) > 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == NULL) $datos["cantidad"] = 1;
  			if($product > 0){
  				$datos["cantidad"] = $product + $datos["cantidad"];
  				$this->Actualiza($datos, null); // null es resta
  			} else {
  				$this->Agregar($datos);
  			}
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



   public function RestaVenta($datos){ // restar productos rapidamente

  		if($this->ObtenerCantidad($datos["cod"]) >= 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == NULL) $datos["cantidad"] = 1;
  			
  			if($product > 1){
  				$datos["cantidad"] = $product - $datos["cantidad"];
  				$this->Actualiza($datos, 1); // uno suma
  			} else {
  				Alerts::Alerta("error","Error!","No se encontro el producto!");
  			}
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



	public function Agregar($datos) { // agrega el producto
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

		$datox = array();
	    $datox["cod"] = $datos["cod"];
	    $datox["cant"] = $datos["cantidad"];
	    $datox["producto"] = $this->ObtenerNombre($datos["cod"]);
	    $datox["pv"] = $pv;  				   
	    $datox["stotal"] = $stot;	    				   
	    $datox["imp"] = $im;
	    $datox["total"] = $stot + $im;
	    $datox["num_fac"] = 0;
	    $datox["fecha"] = date("d-m-Y");
	    $datox["hora"] = date("H:i:s");
	    $datox["orden"] = $_SESSION["orden"];
	    $datox["cajero"] = $_SESSION['nombre'];
	    $datox["tipo_pago"] = 1;
	    $datox["user"] = $_SESSION['user'];
	    $datox["tx"] = $_SESSION['tx'];
	    $datox["fechaF"] = Fechas::Format(date("d-m-Y"));
	    $datox["edo"] = 1;
	    $hash = Helpers::HashId();
	    $datox["hash"] = $hash;
		$datox["time"] = Helpers::TimeId();
	    $datox["td"] = $_SESSION["td"];
	    if ($db->insert("ticket", $datox)) {
	       $this->AgregaCaracteristicas($datos, $hash);
	       $this->AgregaUbicacion($datos, $hash);
	       $this->ActualizaProducto($datos["cod"], $datos["cantidad"], NULL);
	    } 

	}




	public function Actualiza($datos,$func) { // agrega el producto suma de uno n uno
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

	    $cambio = array();
	    $cambio["cant"] = $datos["cantidad"];
	    $cambio["pv"] = $pv;
	    $cambio["stotal"] = $stot;
	    $cambio["imp"] = $im;
	    $cambio["total"] = $stot + $im;
	    if (Helpers::UpdateId("ticket", $cambio, "cod='".$datos["cod"]."' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
	       $this->ActualizaProducto($datos["cod"], 1, $func);
	    }

	}


	public function ObtenerNombre($cod){
		$db = new dbConn();

	if ($r = $db->select("descripcion", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")){ 
        return $r["descripcion"];
    	} unset($r); 
    }


	public function ObtenerPrecio($cod, $cant){ // obtiene el precio independientemente la cantidad
		$db = new dbConn();
		// cuento si hay varias fechas
	$a = $db->query("SELECT * FROM producto_precio WHERE producto = '$cod' and td = ".$_SESSION["td"]."");
		$precios = $a->num_rows; $a->close();

			if($precios > 1){ // si hay mas de un precio
					
					if ($r = $db->select("precio", "producto_precio", "WHERE cant <= '$cant' and producto = '$cod' and td = ".$_SESSION["td"]." order by cant desc limit 1")) { 
				        $precio = $r["precio"];
				    } unset($r);

			} else { // si solo hay un precio
				   
				    if ($r = $db->select("precio", "producto_precio", "WHERE producto = '$cod' and td = ".$_SESSION["td"]."")) { 
				        $precio = $r["precio"];
				    } unset($r); 	
			}
				return $precio;
	}




	public function ObtenerCantidad($cod) { // obtine cantiad de productos
		$db = new dbConn();

	if ($r = $db->select("cantidad", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")){ 
        return $r["cantidad"];
    	} unset($r); 
    }


	public function ObtenerCantidadTicket($cod) { // obtine cantiad de productos
		$db = new dbConn();

	if ($r = $db->select("cant", "ticket", "WHERE cod = '$cod' and orden = ".$_SESSION["orden"]." and tx =  ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")){ 
        return $r["cant"];
    	} unset($r); 
    }


	public function ActualizaProducto($cod,$cant,$funt) { // descuenta o regresa los productos
		$db = new dbConn();
		// primero verifico si el producto es un compuesto. si es compuesto o dependiente actualizo todos los productos que este conlleva . si es un servicio no se hace nada
		// 
		    if ($r = $db->select("compuesto, dependiente, servicio", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
		        $compuesto = $r["nombre"]; $dependiente = $r["dependiente"]; $servicio = $r["servicio"];
		    }  unset($r);  

			if($compuesto == "on"){ // aqui veo que productos lleva el producto comp
				
				$a = $db->query("SELECT agregado, cant FROM producto_compuestos WHERE producto = '$cod' and td = ".$_SESSION["td"]."");
				    foreach ($a as $b) {
				    	// comienza actualizar producto
				    	$cantidades = $cant * $b["cant"];
					if($funt == NULL){ // $func null es resta
						$cantidad = $this->ObtenerCantidad($b["agregado"]) - $cantidades; 
					} else {
						$cantidad = $this->ObtenerCantidad($b["agregado"]) + $cantidades; 
					}
				    $cambio = array();
				    $cambio["cantidad"] = $cantidad;
				    Helpers::UpdateId("producto", $cambio, "cod='".$b["agregado"]."' and td = ".$_SESSION["td"]."");
				    // termina la parte de actualizar producto
				} $a->close();

			} elseif($dependiente == "on"){

				$a = $db->query("SELECT dependiente, cant FROM producto_dependiente WHERE producto = '$cod' and td = ".$_SESSION["td"]."");
				    foreach ($a as $b) {
				    	// comienza actualizar producto
				    	$cantidades = $cant * $b["cant"];
					if($funt == NULL){ // $func null es resta
						$cantidad = $this->ObtenerCantidad($b["dependiente"]) - $cantidades; 
					} else {
						$cantidad = $this->ObtenerCantidad($b["dependiente"]) + $cantidades; 
					}
				    $cambio = array();
				    $cambio["cantidad"] = $cantidad;
				    Helpers::UpdateId("producto", $cambio, "cod='".$b["dependiente"]."' and td = ".$_SESSION["td"]."");
				    // termina la parte de actualizar producto
				} $a->close();

			} elseif($servicio == "on"){
				// si es servicio no se hace nada// solo valido la opcion para hacer el else
			} else {
				// comienza actualizar producto
				if($funt == NULL){ // $func null es resta
					$cantidad = $this->ObtenerCantidad($cod) - $cant; 
				} else {
					$cantidad = $this->ObtenerCantidad($cod) + $cant; 
				}
			    $cambio = array();
			    $cambio["cantidad"] = $cantidad;
			    Helpers::UpdateId("producto", $cambio, "cod='$cod' and td = ".$_SESSION["td"]."");
			    // termina la parte de actualizar producto
			}		    
		    
    }


	public function AgregaCaracteristicas($datos, $hash){
		$db = new dbConn();
		// cuento el producto tiene varias caracteristicas
		    $a = $db->query("SELECT * FROM caracteristicas_asig WHERE producto =  '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    	foreach ($a as $b) { // aqui agregare las caracteristicas que lo requieran
		        	$car = $b["caracteristica"];
		        		if($datos["caracteristica"][$car] != NULL){ // si no esta vacia se inserta
							    
							    $datox = array();
							    $datox["orden"] = $_SESSION["orden"];
							    $datox["producto"] = $datos["cod"];
							    $datox["producto_hash"] = $hash;
							    $datox["descuenta"] = 1;
							    $datox["codigo"] = $b["caracteristica"];
							    $datox["cant"] = $datos["caracteristica"][$car];
							    $datox["hash"] = Helpers::HashId();
							    $datox["time"] = Helpers::TimeId();
							    $datox["tx"] = $_SESSION["tx"];
							    $datox["td"] = $_SESSION["td"];
							    $db->insert("ticket_descuenta", $datox);

	    //// aqui descuento la cantidad de caracteristica
	     if ($r = $db->select("cant", "caracteristicas_asig", "WHERE caracteristica = '".$b["caracteristica"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."")) { 
	        $ccar = $r["cant"];
	    } unset($r); 
	    // descuento
	   $cambio = array();
	   $cambio["cant"] = $ccar - $datos["caracteristica"][$car];
	   Helpers::UpdateId("caracteristicas_asig", $cambio, "caracteristica = '".$b["caracteristica"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		        		}
		    	}
		    } $a->close();

	}



	public function AgregaUbicacion($datos, $hash){  // agrega las ubicaciones
		$db = new dbConn();
		
		if($datos["ubicacion"] != NULL){ // si no esta vacia se inserta				    
			    $datox = array();
			    $datox["orden"] = $_SESSION["orden"];
			    $datox["producto"] = $datos["cod"];
			    $datox["producto_hash"] = $hash;
			    $datox["descuenta"] = 2;
			    $datox["codigo"] = $datos["ubicacion"];
			    $datox["cant"] = $datos["cantidad"];
			    $datox["hash"] = Helpers::HashId();
			    $datox["time"] = Helpers::TimeId();
			    $datox["tx"] = $_SESSION["tx"];
			    $datox["td"] = $_SESSION["td"];
			    $db->insert("ticket_descuenta", $datox);

			//// aqui descuento la cantidad de caracteristica
	     if ($r = $db->select("cant", "ubicacion_asig", "WHERE ubicacion = '".$datos["ubicacion"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."")) { 
	        $cubic = $r["cant"];
	    } unset($r); 
	    // descuento
	   $cambio = array();
	   $cambio["cant"] = $cubic - $datos["cantidad"];
	   Helpers::UpdateId("ubicacion_asig", $cambio, "ubicacion = '".$datos["ubicacion"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		}

	}






	public function AddOrden() { //leva el control del autoincremento de los clientes
		$db = new dbConn();

	    if ($r = $db->select("correlativo", "ticket_orden", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by correlativo desc limit 1")) { 
	        $ultimoorden = $r["correlativo"];
	    } unset($r);  

	    	if($ultimoorden == NULL){ $ultimoorden = 0; }
			$datos = array();
		    $datos["nombre"] = NULL;
		    $datos["correlativo"] = $ultimoorden + 1;
		    $datos["empleado"] = $_SESSION["nombre"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["estado"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_orden", $datos); 
		
		$_SESSION["orden"] = $ultimoorden + 1;    
	}




/////////// mostrar los productos agregados



	public function VerProducto() { //leva el control del autoincremento de los clientes
		$db = new dbConn();
		    
		if($_SESSION["orden"] != NULL){
		    
		    $a = $db->query("SELECT * FROM ticket WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    		echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cant</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Subtotal</th>
					      <th scope="col">Impuesto</th>
					      <th scope="col">Total</th>
					      <th scope="col">Borrar</th>
					    </tr>
					  </thead>
					  <tbody>';
		    		foreach ($a as $b) {
		    		   echo '<tr>
						      <th scope="row">'.$b["cant"].'</th>
						      <td>'.$b["producto"].'</td>
						      <td>'.$b["pv"].'</td>
						      <td>'.$b["stotal"].'</td>
						      <td>'.$b["imp"].'</td>
						      <td>'.$b["total"].'</td>
						      <td><a id="borrar-ticket" op="81" hash="'.$b["hash"].'"><i class="fas fa-times-circle red-text fa-lg"></i></a></td>
					</tr>';
				    }
				    	echo '</tbody>
							</table>';
		    } $a->close();

		} else {
			echo '<div class="text-center">Ingrese un producto</div>';
		}    
	}



//// borrar
	
	public function CuentaProductos($orden){ // productde  de la tabla ticket
		$db = new dbConn();

		$a = $db->query("SELECT * FROM ticket WHERE orden = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    
		    return $a->num_rows;
		    $a->close();
    }


	public function DelOrden($orden){ // elimina el registro de la orden
		$db = new dbConn();

		Helpers::DeleteId("ticket_orden", "correlativo = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

	   if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		$opciones = new Opciones();
	   		$opciones->DelCredito();
	   	}
	   	if(isset($_SESSION["cliente_cli"])){ // guardar el registro del cliente
	   		$opciones = new Opciones();
	   		$opciones->DelCliente();
	   	}

	   	$_SESSION["orden"] = NULL;
		
		if(isset($_SESSION["orden"])) unset($_SESSION["orden"]);
		if(isset($_SESSION["descuento"])) unset($_SESSION["descuento"]);
		if(isset($_SESSION["tcredito"])) unset($_SESSION["tcredito"]);


    }


   public function DelVenta($hash, $ver){
	$db = new dbConn();
   	    
   	    if ($r = $db->select("*", "ticket", "WHERE hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
	        $cant_t = $r["cant"];
	        $cod = $r["cod"];
	    }  unset($r); 

   	    if ($r = $db->select("*", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
		$cant_p = $r["cantidad"];
		}  unset($r);  
   	// regreso los valores a los productos
   $cambio = array();
   $cambio["cantidad"] = $cant_p + $cant_t;
   Helpers::UpdateId("producto", $cambio, "cod = '$cod' and td = ".$_SESSION["td"]."");
  	// borro el registro de ticket
  	Helpers::DeleteId("ticket", "hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	// regreso los valores de caracteristica y ubicacion
  	$a = $db->query("SELECT * FROM ticket_descuenta WHERE producto_hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	if($a->num_rows > 0){
  			foreach ($a as $b) {
		        if($b["descuenta"] == 1){ // si es caracteristica
        	   	    if ($r = $db->select("*", "caracteristicas_asig", "WHERE producto = '$cod' and caracteristica = '".$b["codigo"]."' and td = ".$_SESSION["td"]."")) { 
					$cant_car = $r["cant"];
					}  unset($r); 

				   $cambio = array();
				   $cambio["cant"] = $cant_car + $b["cant"];
				   Helpers::UpdateId("caracteristicas_asig", $cambio, "producto = '$cod' and caracteristica = '".$b["codigo"]."' and td = ".$_SESSION["td"]."");  
		        }
		        if($b["descuenta"] == 2){
        	   	    if ($r = $db->select("*", "ubicacion_asig", "WHERE producto = '$cod' and ubicacion = '".$b["codigo"]."' and td = ".$_SESSION["td"]."")) { 
					$cant_u = $r["cant"];
					}  unset($r); 

				   $cambio = array();
				   $cambio["cant"] = $cant_u + $b["cant"];
				   Helpers::UpdateId("ubicacion_asig", $cambio, "producto = '$cod' and ubicacion = '".$b["codigo"]."' and td = ".$_SESSION["td"]."");  		        	
		        }
		    }
  	}  $a->close();
  	// borro caracteristica y ubicacion 
  	Helpers::DeleteId("ticket_descuenta", "producto_hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	// compruebo si hay mas productos sino elimino orden
	  	
	  	if($this->CuentaProductos($_SESSION["orden"]) == 0){
	  		$this->DelOrden($_SESSION["orden"]);
	  	}

	  	if($ver == NULL){
	  		$this->VerProducto();
	  	}
	  	if($ver == 1 and $this->CuentaProductos($_SESSION["orden"]) == 0){
	  		$this->VerProducto();
	  	}
  	
   }
/////// guardar la venta


   	public function Cancelar() { //cancela toda la orden
		$db = new dbConn();

	   	if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		$opciones = new Opciones();
	   		$opciones->DelCredito();
	   	}
	   	if(isset($_SESSION["cliente_cli"])){ // guardar el registro del cliente
	   		$opciones = new Opciones();
	   		$opciones->DelCliente();
	   	}

			$can = $db->query("SELECT * FROM ticket WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    
		    foreach ($can as $cancel) {
		    	$hash = $cancel["hash"];	    
		    	$this->DelVenta($hash, 1);
		    } $can->close();
	}


///////////////////////////////// ordenes ///////////////
///
	public function GuardarOrden() { //guarda la orden para poder facturar
		$db = new dbConn();

	   if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		$opciones = new Opciones();
	   		$opciones->UnsetCredito();
	   	}
	   	if(isset($_SESSION["cliente_cli"])){ // guardar el registro del cliente
	   		$opciones = new Opciones();
	   		$opciones->UnsetCliente();
	   	}	

		$cambios = array();
	   	$cambios["estado"] = 3;
	   	Helpers::UpdateId("ticket_orden", $cambios, "correlativo = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 

		unset($_SESSION["orden"]);
	}

	public function SelectOrden($orden) { //Seleccioa Orden
		$db = new dbConn();

		$cambios = array();
	   	$cambios["estado"] = 1;
	   	Helpers::UpdateId("ticket_orden", $cambios, "correlativo = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 

		$_SESSION["orden"] = $orden;


	   		$opciones = new Opciones();
	   		$opciones->VarCredito();

	}
////////////////////////////////////////////




	public function AddTicketNum($efectivo) { //leva el control del autoincremento de los clientes
		$db = new dbConn();

	    if ($r = $db->select("num_fac", "ticket_num", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by num_fac desc limit 1")) { 
	        $ultimoorden = $r["num_fac"];
	    } unset($r);  

			$datos = array();
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["num_fac"] = $ultimoorden + 1;
		    $datos["orden"] = $_SESSION["orden"];
		    $datos["efectivo"] = $efectivo;
		    $datos["edo"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_num", $datos); 
		
 		return $ultimoorden + 1;
	}




   public function Facturar($datos){
  		$db = new dbConn();

  		$factura = $this->AddTicketNum($datos["efectivo"]);
 		
 		// configuro el tipo de pago
 		if(isset($_SESSION["cliente_c"])) $tpago = 3;
 		elseif(isset($_SESSION["tcredito"])) $tpago = 2;
 		else $tpago = 1;

	    $cambio = array();
	   	$cambio["num_fac"] = $factura;
	   	$cambio["tipo_pago"] = $tpago;
	   	Helpers::UpdateId("ticket", $cambio, "orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

	   	$cambios = array();
	   	$cambios["estado"] = 2;
	   	Helpers::UpdateId("ticket_orden", $cambios, "correlativo = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

	   	$this->FacturaResult($factura, $datos["efectivo"]);

	   	if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		$opciones = new Opciones();
	   		$opciones->ConfirmCredito($factura, $_SESSION["cliente_c"]);
	   		$opciones->UnsetCredito();
	   	}
	   	if(isset($_SESSION["cliente_cli"])){ // guardar el registro del cliente
	   		$opciones = new Opciones();
	   		$opciones->ConfirmCliente($factura, $_SESSION["cliente_cli"]);
	   		$opciones->UnsetCliente();
	   	}
			if(isset($_SESSION["orden"])) unset($_SESSION["orden"]);
			if(isset($_SESSION["descuento"])) unset($_SESSION["descuento"]);
			if(isset($_SESSION["tcredito"])) unset($_SESSION["tcredito"]);
   }





   public function FacturaResult($factura, $efectivo){
  		$db = new dbConn();

    $a = $db->query("SELECT sum(stotal), sum(imp), sum(total) FROM ticket WHERE num_fac = '$factura' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		     $stotal=$b["sum(stotal)"]; $imp=$b["sum(imp)"]; $total=$b["sum(total)"];
		    } $a->close();

if($efectivo == NULL){
	$efectivo = $total;
}

$cambio = $efectivo - $total;
echo '<p class="text-center">Sub Total: '. Helpers::Dinero($stotal) .' ||  Impuestos: '. Helpers::Dinero($imp) . '</p>';

echo '<p class="text-center font-weight-bold">TOTAL:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">EFECTIVO:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($efectivo) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">CAMBIO:</p>'; 
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($cambio) . '</div>'; 


   }









} // Termina la lcase