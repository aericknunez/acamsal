<?php  

class Historial{

	public function __construct(){

	}

	public function HistorialDiario($fecha, $type = NULL) {
		$db = new dbConn();

			$a = $db->query("select cod, sum(cant), sum(total), producto, pv 
          from ticket 
          where cod != 8888 and edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']." GROUP BY cod order by sum(cant) desc");

			if($a->num_rows > 0){
				
				if($type == NULL){
					echo '<h3 class="h3-responsive">PRODUCTOS VENDIDOS DEL DIA :: '.$fecha.'</h3>';
				} else {
					echo '<h3 class="h3-responsive">PRODUCTOS VENDIDOS</h3>';
				}
				    
				echo '<table class="table table-striped table-sm">
						<thead>
					     <tr>
					       <th>Cant</th>
					       <th>Producto</th>
					       <th>Precio</th>
					       <th>Total</th>
					     </tr>
					   </thead>

						<tbody>';

			    foreach ($a as $b) {
		    
			   echo '<tr>
			       <th scope="row">'. $b["sum(cant)"] . '</th>
			       <td>'. $b["producto"] . '</td>
			       <td>'. Helpers::Dinero($b["pv"]) . '</td>
			       <td>'. Helpers::Dinero($b["sum(total)"]) . '</td>
			     </tr>';
			    } 

			    $a->close();

			echo '</tbody>
				</table>';
			

			$ar = $db->query("SELECT sum(cant) FROM ticket where edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ar as $br) {
		     echo "Cantidad de Productos: ". $br["sum(cant)"] . "<br>";
		    } $ar->close();

		    $ag = $db->query("SELECT sum(total) FROM ticket where edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ag as $bg) { $tot = $bg["sum(total)"];
		        echo "Total Vendido: ". Helpers::Dinero($bg["sum(total)"]) . "<br>";
		    } $ag->close();

		    $ap = $db->query("SELECT sum(total) FROM ticket_propina where fecha = '$fecha' and td = ".$_SESSION['td']."");

		     echo "Total Agrupado: ". Helpers::Dinero($prop + $tot) . "<br>";
			} else {
				Alerts::Mensajex("No se encontraron productos para este dia","danger",$boton,$boton2);
			}
					    
					

	}



	public function HistorialMensual($fechax) {
		$db = new dbConn();

		$a = $db->query("select cod, sum(cant), sum(total), producto, pv, fecha 
					                  from ticket 
					                  where cod != 8888 and edo = 1 and fecha like '%$fechax' and td = ".$_SESSION['td']." GROUP BY cod order by sum(cant) desc");
		if($a->num_rows > 0){
						echo '<h3 class="h3-responsive">PRODUCTOS VENDIDOS</h3>
				    <table class="table table-striped">

						<thead>
					     <tr>
					       <th>Cant</th>
					       <th>Producto</th>
					       <th>Precio</th>
					       <th>Total</th>
					     </tr>
					   </thead>

					<tbody>';

			    foreach ($a as $b) {

			   echo '<tr>
			       <th scope="row">'. $b["sum(cant)"] . '</th>
			       <td>'. $b["producto"] . '</td>
			       <td>'. Helpers::Dinero($b["pv"]) . '</td>
			       <td>'. Helpers::Dinero($b["sum(total)"]) . '</td>
			     </tr>';
			    } $a->close();


			    echo '</tbody>
				</table>';

			$ar = $db->query("SELECT sum(cant) FROM ticket where edo = 1 and fecha like '%$fechax' and td = ".$_SESSION['td']."");
		    foreach ($ar as $br) {
		     echo "Cantidad de Productos: ". $br["sum(cant)"] . "<br>";
		    } $ar->close();

		    $ag = $db->query("SELECT sum(total) FROM ticket where edo = 1 and fecha like '%$fechax' and td = ".$_SESSION['td']."");
		    foreach ($ag as $bg) { $tot = $bg["sum(total)"];
		        echo "Total Vendido: ". Helpers::Dinero($bg["sum(total)"]) . "<br>";
		    } $ag->close();

		    echo "Total Agrupado: ". Helpers::Dinero($prop + $tot) . "<br>";
		} else {
			Alerts::Mensajex("No se encontraron registros de ventas en este mes","danger",$boton,$boton2);
		}		    


	}




	public function HistorialCortes($inicio, $fin, $type = NULL) {
		$db = new dbConn();
		$primero = Fechas::Format($inicio);
		$segundo = Fechas::Format($fin);
					$pro=0;
				//busqueda de usuarios
				$a = $db->query("select * from corte_diario where fecha_format BETWEEN '$primero' AND '$segundo' and td = ".$_SESSION['td']." order by fecha_format, id asc");

				if($a->num_rows > 0){
					
					if($type == NULL){
					echo '<h3 class="h3-responsive">HISTORIAL DE CORTES</h3>';
					} else {
					echo '<h3 class="h3-responsive">CORTE REALIZADO</h3>';	
					}


				  echo '<table class="table table-striped">

						<thead>
					     <tr>
					       <th>Fecha</th>
					       <th>Productos</th>					       
					       <th class="d-none d-md-block">Clientes</th>
					       <th>Efectivo</th>
					        <th>Total</th>
					        <th>Gastos</th>
					        <th>Diferencia</th>
					     </tr>
					   </thead>

					   <tbody>';
				$xproductos = 0;	   
				$xclientes = 0;
				$xpropina = 0;
				$xefectivo = 0;
				$xtotal = 0;
				$xgastos = 0; 
				$xdiferecia = 0;

				    foreach ($a as $b) {
				
				if($b["edo"] == 1){
				$xproductos=$xproductos+$b["productos"];
				$xclientes=$xclientes+$b["clientes"];
				$xefectivo=$xefectivo+$b["efectivo_ingresado"];
				$xtotal=$xtotal+$b["total"];
				$xgastos=$xgastos+$b["gastos"];
				$xdiferecia=$xdiferecia+$b["diferencia"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				} 
				  echo '<tr '.$colores.'>
				       <th scope="row">'. $b["fecha"] . '</th>
				       <td>'. $b["productos"] . '</td>
				       <td class="d-none d-md-block">'. $b["clientes"] . '</td>
				       <td>'. Helpers::Dinero($b["efectivo"]) . '</td>
				       <td>'. Helpers::Dinero($b["total"]) . '</td>
				       <td>'. Helpers::Dinero($b["gastos"]) . '</td>
				       <td>'. Helpers::Dinero($b["diferencia"]) . '</td>
				     </tr>';
				unset($colores);
				    }
				   $a->close();

			if($type == NULL){
			echo '<tr class="light-blue lighten-4">
			       <th scope="row">Totales</th>
			       <td>'. $xproductos . '</td>
			       <td class="d-none d-md-block">'. $xclientes . '</td>
			       <td>'. Helpers::Dinero($xefectivo) . '</td>
			       <td>'. Helpers::Dinero($xtotal) . '</td>
			       <td>'. Helpers::Dinero($xgastos) . '</td>
			       <td>'. Helpers::Dinero($xdiferecia) . '</td>
			     </tr>';
			 	}

			echo '</tbody>
				</table>';
			if($type == NULL){
			echo "Fechas afectadas desde el: ". $inicio ." hasta el ". $fin ." <br>";
			}
			
			} else {
				Alerts::Mensajex("No se encontraron registros de cortes en estas fechas","danger",$boton,$boton2);
			}
					    
					

	}




















	public function HistorialGDiario($fecha, $type = NULL) {
		$db = new dbConn();

		$a = $db->query("SELECT * FROM gastos WHERE fecha = '$fecha' and td = ". $_SESSION["td"] ." order by id desc");
	        	$total=0;
	        	if($a->num_rows > 0){

	        if($type == NULL){
	        echo ' <h3 class="h3-responsive">GASTOS DEL DIA : '.$fecha.'</h3>';
	        } else {
	        echo ' <h3 class="h3-responsive">GASTOS DEL DIA</h3>';
	        }

			echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Tipo</th>
			      <th scope="col">Gasto</th>
			      <th scope="col">Descripci&oacuten</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Imagen</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {

		    	if($b["edo"] == 1){
				$total = $total + $b["cantidad"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				}
		    	echo '<tr '.$colores.'>
			      <th scope="row">'. Helpers::Gasto($b["tipo"]) .'</th>
			      <td>'. $b["nombre"] .'</td>
			      <td>'. $b["descripcion"] .'</td>
			      <td>'. Helpers::Dinero($b["cantidad"]) .'</td>
			      <td>'; 

			    $aw = $db->query("SELECT imagen FROM gastos_images WHERE gasto = ". $b["id"] ." and td = ".$_SESSION["td"]."");
				if($aw->num_rows > 0){
				echo '<a id="xver" iden="'. $b["id"] .'">
					<span class="badge green"><i class="fas fa-image" aria-hidden="true"></i></span>
					</a>';	
				} else {
				echo '<a>
					<span class="badge red"><i class="fas fa-ban" aria-hidden="true"></i></span>
					</a>';	
				}
				$aw->close();
  
			    echo '</td>
			    </tr>';
		    }
		    echo '<tr>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col">Total</th>
			      <th scope="col">'. Helpers::Dinero($total) .'</th>
			      <td></td>
			    </tr>
			    </tbody>
		    </table>';
			echo "El numero de registros es: ". $a->num_rows . "<br>";

			$ag = $db->query("SELECT sum(cantidad) FROM gastos where tipo != 5 and edo = 1 and  fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ag as $bg) {
		        echo "Efectivo afectado: ". Helpers::Dinero($bg["sum(cantidad)"]) . "<br>";
		    } $ag->close();

		   $as = $db->query("SELECT sum(cantidad) FROM gastos where tipo = 5 and edo = 1 and  fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($as as $bs) {
		        echo "Cheques emitidos: ". Helpers::Dinero($bs["sum(cantidad)"]) . "<br>";
		    } $as->close();


			} // num rows
			else {
				Alerts::Mensajex("No se encontraron gastos para este dia","danger",$boton,$boton2);
			}
			$a->close();

			

	}



	public function HistorialGMensual($fechax) {
		$db = new dbConn();

					$a = $db->query("SELECT * FROM gastos WHERE fecha like '%$fechax' and td = ". $_SESSION["td"] ." order by fechaF desc");
	        	$total=0;
	        	if($a->num_rows > 0){
	        echo ' <h3 class="h3-responsive">HISTORIAL DE GASTOS</h3>

				<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Tipo</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Gasto</th>
			      <th scope="col">Descripci&oacuten</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Imagen</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {
		    	
		    	if($b["edo"] == 1){
				$total = $total + $b["cantidad"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				}
		    	echo '<tr '.$colores.'>
			      <th scope="row">'. Helpers::Gasto($b["tipo"]) .'</th>
			      <td>'. $b["fecha"] .'</td>
			      <td>'. $b["nombre"] .'</td>
			      <td>'. $b["descripcion"] .'</td>
			      <td>'. Helpers::Dinero($b["cantidad"]) .'</td>
			      <td>'; 

			    $aw = $db->query("SELECT imagen FROM gastos_images WHERE gasto = ". $b["id"] ." and td = ".$_SESSION["td"]."");
				if($aw->num_rows > 0){
				echo '<a id="xver" iden="'. $b["id"] .'">
					<span class="badge green"><i class="fas fa-image" aria-hidden="true"></i></span>
					</a>';	
				} else {
				echo '<a>
					<span class="badge red"><i class="fas fa-ban" aria-hidden="true"></i></span>
					</a>';	
				}
				$aw->close();
					  
			    echo '</td>
			    </tr>';
		    }
		    echo '<tr>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col">Total</th>
			      <td>'. Helpers::Dinero($total) .'</td>
			    </tr>
			    </tbody>
		    </table>';
			echo "El numero de registros es: ". $a->num_rows . "<br>";
			
			$ag = $db->query("SELECT sum(cantidad) FROM gastos where tipo != 5 and edo = 1 and  fecha like '%$fechax' and td = ".$_SESSION['td']."");
		    foreach ($ag as $bg) {
		        echo "Efectivo afectado: ". Helpers::Dinero($bg["sum(cantidad)"]) . "<br>";
		    } $ag->close();

		   $as = $db->query("SELECT sum(cantidad) FROM gastos where tipo = 5 and edo = 1 and  fecha like '%$fechax' and td = ".$_SESSION['td']."");
		    foreach ($as as $bs) {
		        echo "Cheques emitidos: ". Helpers::Dinero($bs["sum(cantidad)"]) . "<br>";
		    } $as->close();


			} else {
			Alerts::Mensajex("No se encontraron registros de gastos en este mes","danger",$boton,$boton2);
			}
  			$a->close();


	}




//// ver abonos

public function VerAbonos($fecha) { //leva el control del autoincremento de los clientes
    $db = new dbConn();
        
        $a = $db->query("SELECT * FROM creditos_abonos WHERE fecha = '$fecha' and td = ".$_SESSION["td"]." order by id desc");

        if($a->num_rows > 0){
        	echo ' <h3 class="h3-responsive">ABONOS REALIZADOS</h3>'; 

            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Abono</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
              </tr>
            </thead>
            <tbody>';
            $n = 1;
            foreach ($a as $b) {
            	if($b["edo"] == 1){
		            echo '<tr>
		                  <th scope="row">'.$b["nombre"].'</th>
		                  <td>'.Helpers::Dinero($b["abono"]).'</td>
		                  <td>'.$b["fecha"].'</td>
		                  <td>'.$b["hora"].'</td>';
		              echo '</tr>';
		            $n ++;
        		} else {
        			echo '<tr class="text-danger">
		                  <th scope="row">'.$b["nombre"].'</th>
		                  <td>'.Helpers::Dinero($b["abono"]).'</td>
		                  <td>'.$b["fecha"].'</td>
		                  <td>'.$b["hora"].'</td>
		                  </tr>';
		            $n ++;
		                
		                if($r = $db->select("nombre", "login_userdata", "WHERE user = '".$b["user_del"]."' and td = ".$_SESSION["td"]."")) { 
					        $nombre = $r["nombre"]; }  unset($r); 

		            echo '<tr class="text-danger">
		                  <th colspan="4">Eliminado por: '.$nombre.'</th>
						</tr>';
        		}
            }
              echo '</tbody>
              </table>';

			echo "El numero de registros es: ". $a->num_rows . "<br>";
			$a->close();
			$ag = $db->query("SELECT sum(abono) FROM creditos_abonos where edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ag as $bg) {
		        echo "Efectivo abonado: ". Helpers::Dinero($bg["sum(abono)"]) . "<br>";
		    } $ag->close();


        } else {
			Alerts::Mensajex("No se encontraron registros de abonos","danger",$boton,$boton2);
			}


   
  }









////////////consolidado diario
	public function ConsolidadoDiario($fecha) {
		$db = new dbConn();

		$this->HistorialCortes($fecha, $fecha, 1);
		echo "<br>";
		$this->VerAbonos($fecha);
		echo "<br>";
		$this->HistorialGDiario($fecha, 1);
		echo "<br>";
		$this->HistorialDiario($fecha, 1);
		echo "<br>";
	}







// termina la clase
 }


?>