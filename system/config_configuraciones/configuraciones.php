<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Configuraciones</h1>
Datos Generales del Sistema
    <table class="table table-sm table-striped">

   <thead>
     <tr>
       <th>Item</th>
       <th>Configuraci&oacuten</th>
     </tr>
   </thead>

   <tbody>
    <?
$r = $db->select("*", "config_master", "where td = ".$_SESSION['td']."")
?>
<tr>
       <td>Sistema</td>
       <td><? echo $r["sistema"]; ?></td>
       
     </tr>
     <tr>
       <td>Cliente</td>
       <td><? echo $r["cliente"]; ?></td>
       
     </tr>
     <tr>
       <td>Slogan</td>
       <td><? echo $r["slogan"]; ?></td>
       
     </tr>
     <tr>
       <td>Propietario</td>
       <td><? echo $r["propietario"]; ?></td>
       
     </tr>
     <tr>
       <td>Tel&eacutefono</td>
       <td><? echo $r["telefono"]; ?></td>
       
     </tr>
     <tr>
       <td>Direcci&oacuten</td>
       <td><? echo $r["direccion"]; ?></td>
       
     </tr>
     <tr>
       <td>Email</td>
       <td><? echo $r["email"]; ?></td>
       
     </tr>
     <tr>
       <td>Imagen</td>
       <td><? echo $r["imagen"]; ?></td>
       
     </tr>
     <tr>
       <td>Giro</td>
       <td><? echo $r["giro"]; ?></td>
       
     </tr>
     <tr>
       <td>NIT</td>
       <td><? echo $r["nit"]; ?></td>
       
     </tr>
     <tr>
       <td>Impuesto</td>
       <td><? echo $r["imp"]; ?></td>
       
     </tr>
     <tr>
       <td>Tipo Inicio Venta</td>
       <td><? if($r["tipo_inicio"] == 1) echo "Venta por Codigos"; else echo "Venta por Busqueda"; ?></td>    
     </tr>

     <tr>
       <td>Pais</td>
       <td><? echo Helpers::Pais($r["pais"]); ?></td>    
     </tr>

     <tr>
       <td>Moneda</td>
       <td><? echo $r["moneda"] . " | " . $r["moneda_simbolo"]; ?></td>    
     </tr>
    <tr>
       <td>Nombre Impuesto</td>
       <td><? echo $r["nombre_impuesto"]; ?></td>    
     </tr>
    <tr>
       <td>Nombre Documento</td>
       <td><? echo $r["nombre_documento"]; ?></td>    
     </tr>
    <tr>
       <td>Inicio Tx Factura</td>
       <td><? if($r["inicio_tx"] == 1) echo "Facturando"; else echo "Sin Facturar"; ?></td>    
     </tr>
     <tr>
       <td>Skin</td>
       <td><? echo $r["skin"]; ?></td>    
     </tr>
         <tr>
       <td>Otras Ventas</td>
       <td><? if($r["otras_ventas"] == 1) echo "Activado"; else echo "Inactivo"; ?></td>    
     </tr>

     <tr>
       <td>Permimitir cambiar Tx</td>
       <td><? if($r["cambio_tx"] == "on") echo "Activado"; else echo "Inactivo"; ?></td>    
     </tr>

<?
 unset($r);  

   ?>
   </tbody>
</table>

<a href="?modal=conf_config" class="btn btn-indigo">Cambiar configuraciones<i class="fa fa-cog ml-2"></i></a>
<a href="?modal=img_negocio" class="btn btn-cyan">Cambiar Imagen<i class="fa fa-user ml-2"></i></a>
