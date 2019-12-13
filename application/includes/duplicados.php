<?
include_once '../common/Helpers.php';
include_once 'variables_db.php';
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();
include_once '../common/Encrypt.php';
include_once '../common/Mysqli.php';
include_once '../common/Fechas.php';
include_once '../../system/corte/Corte.php';
include_once '../../system/sync/Sync.php';
include_once '../../system/index/Inicio.php';

if($_REQUEST["fecha"] == NULL){
   $fecha = date("d-m-Y"); 
} else {
    $fecha = $_REQUEST["fecha"];
}

Delete("corte_diario", "user", $fecha);

// Delete("ticket", "cod", $fecha);
// Delete("ticket_num", "mesa", $fecha);
// Delete("mesa_nombre", "mesa", $fecha);
// Delete("gastos_images", "imagen", $fecha);
// Delete("mesa", "mesa", $fecha);
// Delete("gastos", "tipo", $fecha);
// Delete("control_cocina", "mesa", $fecha);


  function Delete($tabla, $cod, $fecha){
    $db = new dbConn();

        $a = $db->query("SELECT * FROM $tabla WHERE fecha = '$fecha'");


        $contador = 0;
    foreach ($a as $b) { //$b["id"]
        $hora=$b["hora"];
        $codigo = $b[$cod];
                
                $ax = $db->query("SELECT * FROM $tabla WHERE hora = '$hora' and $cod = '$codigo' and fecha = '$fecha'");

                if($ax->num_rows > 1){
                    $contador = $contador + $ax->num_rows;
                    $cant = $ax->num_rows - 1;

                    if ( $db->delete("$tabla", "WHERE hora = '$hora' and $cod = '$codigo' and fecha = '$fecha' LIMIT " . $cant)) {
                            echo "$cant - Record Deleted!<br />"; 
                        } unset($cant);

                    $ax->close();
                } 


    }  echo $tabla . " -- ".$contador." <br>";
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