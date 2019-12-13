<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


if($_REQUEST["op"] == "1" and $_POST["precio"] != null){

$iden=$_REQUEST["iden"];

    $cambio = array();
    $cambio["precio"] = $_POST["precio"];
    if ($db->update("precios", $cambio, "WHERE id='$iden'")) {
        
    } 

}

?>
<h1>Configuraci&oacuten de precios</h1>
    <table class="table table-sm table-striped">

   <thead>
     <tr>
       <th scope="col">Codigo</th>
       <th scope="col">Producto</th>
       <th scope="col">Categoria</th>
       <th scope="col">Precio</th>
      <th scope="col">Editar</th>
     </tr>
   </thead>

   <tbody>
<?
//busqueda de usuarios
$a = $db->query("SELECT id, cod, nombre, cat, precio FROM precios WHERE td = ".$_SESSION['td']."");
    foreach ($a as $b) {

// BUSCO LA CATEGORIA
if($b["cat"] != 0){
$r = $db->select("categoria", "categorias", "where cod = ". $b["cat"] ." and td = ".$_SESSION['td'].""); $cate=$r["categoria"]; unset($r); /////
} else { $cate = "Ninguna"; }


echo '<form id="'. $b["id"] . '" method="post" action="index.php?precios&op=1&iden='. $b["id"] . '"';
	echo '<tr>
       <th scope="row">'. $b["cod"] . '</th>
       <td>'. $b["nombre"] . '</td>
       <td>'. $cate . '</td>
       <td>'. $b["precio"] . '</td>
       <td><input name="precio" type="number" id="precio" step="any" size="10" maxlength="8" class="form-control" placeholder="0.00"></td>
     </tr>';
echo '</form>';
 

    }
   $a->close();

    ?>
   </tbody>

</table>
