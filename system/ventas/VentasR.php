<?php 
class Ventas{

	public function __construct() { 
 	} 



   public function SumaVenta($datos){ // Rapida

  		if($this->ObtenerCantidad($datos["cod"]) > 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			if($datos["cantidad"] == NULL or $datos["cantidad"] == 0) $datos["cantidad"] = 1;
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == 1){
	  			$datos["cantidad"] = $product + 1;
  			}


  			if($product > 0){  				
  				$this->Actualiza($datos, null); // null es resta
  			} else {
  				$this->Agregar($datos);
  			}
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



   public function RestaVenta($datos){ // Rapida

  		if($this->ObtenerCantidad($datos["cod"]) >= 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
	  		if($datos["cantidad"] == NULL or $datos["cantidad"] == 0) $datos["cantidad"] = 1;
	  		$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == 1){
	  			$datos["cantidad"] = $product - 1;
  			}
  			
  			if($product > 1){  				
  				$this->Actualiza($datos, 1); // uno suma
  			} 
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



	public function AplicarDescuento() { //Aplica el descuento a los productos
		$db = new dbConn();
				    
		    $a = $db->query("SELECT * FROM ticket WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    	foreach ($a as $b) {
		    		$datos["cantidad"] = $b["cant"];
		    		$datos["cod"] = $b["cod"];
		    		$this->Actualiza($datos, 1);
		    	}
		    } $a->close();

		    if($_SESSION['descuento'] != NULL){
		 $lateral = new Laterales(); 
   		 $precio = $lateral->ObtenerTotal($_SESSION["orden"]);
		  $texto = 'El total en esta venta es de: ' . $precio;
		  Alerts::Mensajex($texto,"success",$boton,$boton2);



		  $texto = 'Esta venta posee un descuento de : ' . $_SESSION['descuento']. " %";
		  Alerts::Mensajex($texto,"danger",'<a id="quitar-descuento" op="96" class="btn btn-danger btn-rounded">Quitar Descuento</a>',$boton2);
		} else {
			$lateral = new Laterales();
			    $precio = $lateral->ObtenerTotal($_SESSION["orden"]);
			  $texto = 'El total en esta venta sin descuento es de: ' . $precio;
			  Alerts::Mensajex($texto,"success",$boton,$boton2);
			} 

	}




	public function Agregar($datos) { // agrega el producto
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

	if($_SESSION['descuento'] != NULL){
		$sumas = Helpers::Descuento($sumas);
		$pv = Helpers::Descuento($pv);
	}

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
	    $db->insert("ticket", $datox);

	}




	public function Actualiza($datos,$func) { // agrega el producto suma de uno n uno
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

	if($_SESSION['descuento'] != NULL){
		$sumas = Helpers::DescuentoTotal($sumas);
		$pv = Helpers::DescuentoTotal($pv);
	}

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

	    $cambio = array();
	    $cambio["cant"] = $datos["cantidad"];
	    $cambio["pv"] = $pv;
	    $cambio["stotal"] = $stot;
	    $cambio["imp"] = $im;
	    $cambio["total"] = $stot + $im;
	    Helpers::UpdateId("ticket", $cambio, "cod='".$datos["cod"]."' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

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
					      <th scope="col">Total</th>';
					    
					    if($_SESSION["tipo_inicio"] == 1){
					    	echo '<th scope="col">OP</th>';
					    }
					    echo '<th scope="col">Borrar</th>
					    </tr>
					  </thead>
					  <tbody>';
		    		foreach ($a as $b) {
		    		   echo '<tr>
						      <th scope="row"><a href="?modal=cantidad&cant='.$b["cant"].'&cod='.$b["cod"].'">'.$b["cant"].'</a></th>
						      <td>'.$b["producto"].'</td>
						      <td>'.$b["pv"].'</td>
						      <td>'.$b["stotal"].'</td>
						      <td>'.$b["imp"].'</td>
						      <td>'.$b["total"].'</td>
			    			<td><a id="modcant" op="91" cod="'.$b["cod"].'"><i class="fas fa-minus-circle red-text fa-lg"></i></a>  <a id="modcant" op="90" cod="'.$b["cod"].'"><i class="fas fa-plus-circle green-text fa-lg"></i></a></td>
			    			<td><a id="borrar-ticket" op="92" hash="'.$b["hash"].'"><i class="fas fa-times-circle red-text fa-lg"></i></a></td>
					</tr>';
				    }
				    	echo '</tbody>
							</table>';
		    } $a->close();

		    $this->Sonar();
		} else {
			echo '<div class="text-center">Ingrese un producto</div>
			<div align="center"><a data-toggle="modal" data-target="#ModalBusqueda" class="btn-floating btn-primary"><i class="fas fa-search"></i></a></div>';
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


		if(isset($_SESSION["orden"])) unset($_SESSION["orden"]);
		if(isset($_SESSION["descuento"])) unset($_SESSION["descuento"]);
		if(isset($_SESSION["tcredito"])) unset($_SESSION["tcredito"]);

    }


   public function DelVenta($hash, $ver){
	$db = new dbConn();

  	// borro el registro de ticket
  	Helpers::DeleteId("ticket", "hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
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









//////////////// factura

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


	public function DescontarProducto($factura) { // Descuenta los productods del inventario segun factura
		$db = new dbConn();

	    $ax = $db->query("SELECT * FROM ticket WHERE num_fac = '$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
	    foreach ($ax as $bx) {

		// primero verifico si el producto es un compuesto. si es compuesto o dependiente actualizo todos los productos que este conlleva . si es un servicio no se hace nada
		// 
		    if ($r = $db->select("compuesto, dependiente, servicio", "producto", "WHERE cod = '".$bx["cod"]."' and td = ".$_SESSION["td"]."")) { 
		        $compuesto = $r["nombre"]; $dependiente = $r["dependiente"]; $servicio = $r["servicio"];
		    }  unset($r);  

			if($compuesto == "on"){ // aqui veo que productos lleva el producto comp
				
				$a = $db->query("SELECT agregado, cant FROM producto_compuestos WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."");
				    foreach ($a as $b) {
				    	// comienza actualizar producto
				    	$cantidades = $bx["cant"] * $b["cant"];
						$cantidad = $this->ObtenerCantidad($b["agregado"]) - $cantidades; 
			
				    $cambio = array();
				    $cambio["cantidad"] = $cantidad;
				    Helpers::UpdateId("producto", $cambio, "cod='".$b["agregado"]."' and td = ".$_SESSION["td"]."");
				    // termina la parte de actualizar producto
				} $a->close();

			} elseif($dependiente == "on"){

				$a = $db->query("SELECT dependiente, cant FROM producto_dependiente WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."");
				    foreach ($a as $b) {
				    	// comienza actualizar producto
				    	$cantidades = $bx["cant"] * $b["cant"];
						$cantidad = $this->ObtenerCantidad($b["dependiente"]) - $cantidades; 

				    $cambio = array();
				    $cambio["cantidad"] = $cantidad;
				    Helpers::UpdateId("producto", $cambio, "cod='".$b["dependiente"]."' and td = ".$_SESSION["td"]."");
				    // termina la parte de actualizar producto
				} $a->close();

			} elseif($servicio == "on"){
				// si es servicio no se hace nada// solo valido la opcion para hacer el else
			} else {

					$cantidad = $this->ObtenerCantidad($bx["cod"]) - $bx["cant"]; 
			    $cambio = array();
			    $cambio["cantidad"] = $cantidad;
			    Helpers::UpdateId("producto", $cambio, "cod='".$bx["cod"]."' and td = ".$_SESSION["td"]."");
			    // termina la parte de actualizar producto
			}	////////////////




	    } $ax->close();	

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

	   	$this->DescontarProducto($factura);
	   	$this->FacturaResult($factura, $datos["efectivo"]);

	   	if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		$opciones = new Opciones();
	   		$opciones->ConfirmCredito($factura, $_SESSION["cliente_c"]);
	   		$opciones->UnsetCredito();
	   		$_SESSION["creditofactura"] = TRUE;
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


	public function Sonar(){
		echo '<audio id="audioplayer" autoplay=true>
				  <source src="assets/sound/bleep.mp3" type="audio/mpeg">
				  <source src="assets/sound/bleep.ogg" type="audio/ogg">
				</audio>';
	}



///////////////////// agregar credito

  public function ClienteBusqueda($dato){ // Busqueda para cliente
    $db = new dbConn();

          $a = $db->query("SELECT * FROM clientes WHERE nombre like '%".$dato["keyword"]."%' or documento like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-c" hash="'. $b["hash"] .'" nombre="'. $b["nombre"] .'">'. $b["nombre"] .'   ||   '. $b["documento"].'</a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un cliente";
          }
  }


  public function AgregaCliente($dato){ // Busqueda para cliente 
    $db = new dbConn();

       	$_SESSION["cliente_c"] = $_POST["hash"]; // asigna el credito
		$_SESSION["cliente_credito"] = $_POST["nombre"];

       	$_SESSION["cliente_cli"] = $_POST["hash"]; // seguimiento a la factura
		$_SESSION["cliente_asig"] = $_POST["nombre"];

		$opciones = new Opciones(); // guarda registro
	   	$opciones->AddCredito();
	   	$opciones->AddCliente();

  		$texto = 'Cliente asignado para credito: ' . $_SESSION['cliente_credito']. ".";
		Alerts::Mensajex($texto,"danger",'<a id="quitar-cliente" op="99" class="btn btn-danger btn-rounded">Quitar Cliente</a>',$boton2);


		$cambio = array();
	    $cambio["nombre"] = $_SESSION["cliente_asig"];
	    Helpers::UpdateId("ticket_orden", $cambio, "correlativo = '".$_SESSION["orden"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

  }




///////////////////// agregar credito

  public function ClienteBusquedaA($dato){ // Busqueda para cliente
    $db = new dbConn();

          $a = $db->query("SELECT * FROM clientes WHERE nombre like '%".$dato["keyword"]."%' or documento like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-cli" hash="'. $b["hash"] .'" nombre="'. $b["nombre"] .'">'. $b["nombre"] .'   ||   '. $b["documento"].'</a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un cliente";
          }
  }


  public function AgregaClienteA($dato){ // agrega  cliente
    $db = new dbConn();

       	$_SESSION["cliente_cli"] = $_POST["hash"];
		$_SESSION["cliente_asig"] = $_POST["nombre"];
		
		$opciones = new Opciones(); // guarda registro
	   	$opciones->AddCliente(); 

  		$texto = 'Cliente asignado para la Factura: ' . $_SESSION['cliente_asig']. ".";
		Alerts::Mensajex($texto,"danger",'<a id="quitar-clienteA" op="89" class="btn btn-danger btn-rounded">Quitar Cliente</a>',$boton2);

		$cambio = array();
	    $cambio["nombre"] = $_SESSION["cliente_asig"];
	    Helpers::UpdateId("ticket_orden", $cambio, "correlativo = '".$_SESSION["orden"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");   
  }


///////////////////// agregar Documento

  public function DocumentoBusqueda($dato){ // Busqueda para documento
    $db = new dbConn();

          $a = $db->query("SELECT * FROM facturar_documento WHERE cliente like '%".$dato["keyword"]."%' or documento like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-d" documento="'. $b["documento"] .'" cliente="'. $b["cliente"] .'">'. $b["cliente"] .'</a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un cliente";
          }
  }



  public function AgregaDocumento($dato){ // Busqueda para documento
    $db = new dbConn();

       	$_SESSION["factura_cliente"] = $_POST["cliente"];
		$_SESSION["factura_documento"] = $_POST["documento"];
  		
  		$texto = $_SESSION['config_nombre_documento']. ": " . $_SESSION["factura_documento"] . "<br> Cliente: " . $_SESSION["factura_cliente"];
		Alerts::Mensajex($texto,"danger",'<a id="quitar-documento" op="102" class="btn btn-danger btn-rounded">Quitar '.$_SESSION["config_nombre_documento"].'</a>',$boton2);

  }















} // Termina la lcase