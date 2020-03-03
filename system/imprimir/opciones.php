<?php 
  if($_SERVER['HTTP_REFERER'] == NULL) $dir = "http://". $_SERVER['HTTP_HOST'] . "/acamsal"; else $dir = $_SERVER['HTTP_REFERER'];


if ($_GET["op"] == 1) { /// imprimir listado de cuotas pendientes
    include_once '../../system/asociado/Asociado.php';
    $asociado = new Asociados(); 
    echo '<h2 class="h2-responsive">Listado de cuotas pendientes</h2>';
    $asociado->VerCuotasPendientes(); 
}

if($_GET["op"] == 2){
    include_once '../../system/asociado/Asociado.php';
    $asociado = new Asociados(); 
    echo '<h2 class="h2-responsive">Productos adquiridos por el asociado</h2>';
    $asociado->VerProductosAsociado($_GET["as"], $_GET["inicio"], $_GET["fin"]);

    $dir = "http://". $_SERVER['HTTP_HOST'] . "/acamsal/?asociadover";
}



if ($_GET["op"] == 10) { /// imprimir listado de cuotas pendientes
    include_once 'Imprime.php';
    $print = new Imprime(); 
    $print->TodosProductos(); 
}

if ($_GET["op"] == 11) { /// imprimir listado de cuotas pendientes
    include_once 'Imprime.php';
    $print = new Imprime(); 
    $print->BajasExistencias(); 
}




?>