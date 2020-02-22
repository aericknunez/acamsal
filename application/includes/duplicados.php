<?php
include_once '../common/Helpers.php'; // [Para todo]
include_once '../includes/variables_db.php';
include_once '../common/Mysqli.php';
$db = new dbConn();
include_once '../includes/DataLogin.php';
$seslog = new Login();
$seslog->sec_session_start();

include_once '../common/Fechas.php';


if($_REQUEST["fecha"] == NULL){
   $fecha = date("d-m-Y"); 
} else {
    $fecha = $_REQUEST["fecha"];
}



    $ad = $db->query("SELECT tabla FROM sync_tabla");
    foreach ($ad as $bd) {

        Delete($bd["tabla"], $fecha);

    } $ad->close();



// Delete("corte_diario", $fecha);

  function Delete($tabla, $fecha){
    $db = new dbConn();

        $a = $db->query("SELECT hash, time FROM $tabla WHERE fecha = '$fecha'");


        $contador = 0;
    foreach ($a as $b) { //$b["id"]
        $hash=$b["hash"];
        $time=$b["time"];
                
                $ax = $db->query("SELECT * FROM $tabla WHERE hash = '$hash' and time = '$time' and fecha = '$fecha'");

                if($ax->num_rows > 1){
                    $contador = $contador + $ax->num_rows;
                    $cant = $ax->num_rows - 1;

                $db->delete("$tabla", "WHERE hash = '$hash' and time = '$time' and fecha = '$fecha' LIMIT " . $cant);
                unset($cant);

                    $ax->close();
                } 


    }
        unset($contador);

    $a->close();
 }
 




///////redirect

 $fechax = new Fechas();

 $next = $fechax->DiaSiguiente($fecha);

 sleep(2);

 echo '<script>
    window.location.href="?fecha='. $next.'"
</script>';