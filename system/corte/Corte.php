<?php 
class Corte{

	public function __construct() { 
     } 


     public function Execute($efectivo, $fecha){
     	$db = new dbConn();

	     	if($this->UltimaFecha() != $fecha){
			
				$caja_chica=$this->GetEfectivo();
			    

			    $datos = array();
			    $datos["fecha"] = $fecha;
			    $datos["fecha_format"] = Fechas::Format($fecha);
			    $datos["hora"] = date("H:i:s");
			    $datos["productos"] = $this->ProductosHoy($fecha);
			    $datos["clientes"] = $this->ClientesHoy($fecha);
			    $datos["efectivo_ingresado"] = $efectivo;
			    $datos["tx"] = $this->TotalTx($fecha);
			    $datos["no_tx"] = $this->TotalNoTx($fecha);
			    $datos["total"] = $this->VentaHoy($fecha);
			    $datos["t_efectivo"] = $this->TVentasX($fecha, 1);
			    $datos["t_tarjeta"] = $this->TVentasX($fecha, 2);
			    $datos["t_credito"] = $this->TVentasX($fecha, 3);
			    $datos["gastos"] = $this->GastoHoy($fecha);
			    $datos["diferencia"] = $this->DiferenciaDinero($caja_chica, $efectivo, $fecha);
			    $datos["user"] = $_SESSION["user"];
			    $datos["edo"] = 1;
			    $datos["hash"] = Helpers::HashId();
			    $datos["time"] = Helpers::TimeId();
			    $datos["td"] = $_SESSION["td"];
			    if ($db->insert("corte_diario", $datos)) {
			        

			        	if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0 and $_SESSION["root_tipo_sistema"] != 0){
				   		echo '<script>
							window.location.href="?modal=respaldar"
						</script>';
				   		}

			    } 

	     	} else { // se detecto corte

	     	}

     }





	public function UltimaFecha(){
		$db = new dbConn();
	    if ($r = $db->select("fecha", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["fecha"];
	    } unset($r); 
	}

	public function CuotasHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM asoc_cuotas WHERE edo = 2 and td = ".$_SESSION["td"]." and dia_cancel = '$fecha'");
		    foreach ($a as $b) {
		     return $b["sum(total)"];
		    } $a->close();
	}

	public function VentaHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     return $b["sum(total)"];
		    } $a->close();
	}
 /// para ver las ventas de un mes especifico // eje feha 05-2019
 	public function VentaMes($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($a as $b) {
		     return $b["sum(total)"];
		    } $a->close();
	}


	public function ProductosHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cant) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     return $b["sum(cant)"];
		    } $a->close();
	}

	public function GastoHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo != 5 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function GastoMes($fecha){ /// para ver los gastos de un mes especifico // eje feha 05-2019
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo != 5 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}


	public function ClientesHoy($fecha){
		$db = new dbConn();
		$a = $db->query("SELECT * FROM ticket_orden WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'");
		return $a->num_rows;
		$a->close();

	}


	public function TotalTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 1");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}

	public function TotalNoTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 0");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}



	public function TVentasX($fecha, $tipo){ // para saber que tipo de venta es
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket 
	    	WHERE edo = 1 and td = ".$_SESSION["td"]." and tipo_pago = '$tipo' and fecha = '$fecha'");
		    foreach ($a as $b) {
		     return $b["sum(total)"];
		    } $a->close();
	}




	public function DiferenciaDinero($caja_chica, $efectivo, $fecha){
		/// conversiones para el dinero
		$total_cc = $this->TVentasX($fecha, 1)+$caja_chica+$this->TotalAbonos($fecha)+$this->EntradasEfectivo($fecha)+$this->CuotasHoy($fecha); //total ventas  mas caja chica de ayer
		$total_debido = $total_cc-$this->GastoHoy($fecha); //dinero que deberia haber ()
		$diferencia = $efectivo - $total_debido;
		return $diferencia;
	}


	public function EntradasEfectivo($fecha){
		$db = new dbConn();
	        $a = $db->query("SELECT sum(cantidad) FROM entradas_efectivo WHERE  edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		        $efectivo=$b["sum(cantidad)"];
		    } $a->close();
		    return  $efectivo;

	}

	public function TotalAbonos($fecha){
		$db = new dbConn();
	       $a = $db->query("SELECT sum(abono) FROM creditos_abonos WHERE td = ".$_SESSION["td"]." and edo = 1 and fecha = '$fecha'");
		    foreach ($a as $b) {
		        $abono=$b["sum(abono)"];
		    } $a->close();
		    return  $abono;

	}
















	public function GetEfectivo(){ // el ultimo efectivo
		$db = new dbConn();
	    if ($r = $db->select("efectivo_ingresado", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) {  return $r["efectivo_ingresado"];
	    } unset($r); 
	}



	public function GetDiferencia($fecha){ //para reporte nada mas
		$db = new dbConn();
	    if ($r = $db->select("diferencia", "corte_diario", "where edo = 1 and fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $diferencia=$r["diferencia"];
	    } 
	    unset($r); 
		return $diferencia;
	}



	public function EfectivoDebido($fecha){ //para reporte efectivo que debe haber
		$db = new dbConn();
	    if($this->UltimaFecha() != $fecha){ // si no se ha echo corte hoy
	    $total_cc = $this->TVentasX($fecha, 1)+$this->GetEfectivo()+$this->TotalAbonos($fecha)+$this->EntradasEfectivo($fecha); //total ventas  mas caja chica de ayer
		$total_debido = $total_cc-$this->GastoHoy($fecha); //dinero que deberia haber ()
		return $total_debido;
		} else { // si se realizo corte solo ver cuanto es el ultimo corte
		return $total_debido = $this->GetEfectivo();
		}
	}











// public function Porcentaje(){
// 	$db = new dbConn();

// 	$cant_g = Corte::TotalTx(date("d-m-Y"));
// 	$cant_e = Corte::TotalNoTx(date("d-m-Y"));

// 	$topor=$cant_g+$cant_e;
// 	$por1=$cant_g*100;
// 	@$por1=$por1/$topor;

// 	$por2=$cant_e*100;
// 	@$por2=$por2/$topor;
// 	$por1=number_format($por1,0,'.','.');
// 	$por2=number_format($por2,0,'.','.');

// 	return "$por1/$por2";

// }







public function CancelarCorte($ramdom,$fecha){
	$db = new dbConn();

	$numero = sha1(Fechas::Format(date("d-m-Y")));
	$num = substr($numero, 0, 6);

		if($ramdom == $num){
				$cambio = array();
			    $cambio["edo"] = "2";
			    
			    if (Helpers::UpdateId("corte_diario", $cambio, "fecha_format=" . Fechas::Format($fecha))) {

					Alerts::Alerta("success","Exito!","Corte Anulado Correctamente");
			    } else {
			Alerts::Alerta("error","Error!","Codigo Invalido!!");
			}
		}

	}







////////////////////////////////// contenido //////////////////////////
	public function Contenido($fecha){
		if($this->UltimaFecha() == $fecha){
				$this->Content($fecha);
			} else {
				$this->Form();
			}
	}
	




	public function Content($fecha){
		//$sync = new Sync;


		 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Efectivo</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetEfectivo()) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total de venta</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->VentaHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Diferencia</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetDiferencia($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Gastos</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GastoHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>

			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalConfirmDelete">Eliminar Corte</button>';
		
	}

	public function Form(){
		Alerts::Mensajex("Aun no se ha realizado el corte de este dia. <br />Ingrese la cantidad de efectivo para poder continuar",'danger',$boton,$boton2);
	echo '<form id="form-corte" name="form-corte">
		 
		 <div class="form-group row justify-content-center align-items-center">
		  <div class="col-xs-2">
		    <label for="ex1">Efectivo</label>
		    <input name="efectivo" type="number" id="efectivo" size="8" maxlength="8" class="form-control" placeholder="0.00" step="any" required autofocus />
		  </div>
		</div>
		<input type="image" src="assets/img/imagenes/print.png"  id="btn-corte" name="btn-corte" >
		</form>';
				
	}




} // fin de la clase

 ?>