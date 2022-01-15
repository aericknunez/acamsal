<?php 
class Herramientas{


  public function ResumenProductos($item, $orden){
    $db = new dbConn();

    if ($orden == "desc") {
      $orden2 = "asc";
    } else{
      $orden2 = "asc";
    }

    $a = $db->query("SELECT * FROM producto Order By $item $orden");

    $n = 1;
    if($a->num_rows > 0){
      
      $cantidad = 0;
      $costo = 0;
      $costot = 0;
      $venta = 0;
      $ventat = 0;
      $utilidad = 0;

      echo '<table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th><a id="paginar" op="350" campo="cod" orden="'.$orden2.'">Cod</a></th>
                  <th class="th-sm"><a id="paginar" op="350" campo="descripcion" orden="'.$orden2.'">Producto</a></th>
                  <th class="th-sm">Cantidad</th>
                  <th class="th-sm">Precio Compra</th>
                  <th class="th-sm">Total Compra</th>
                  <th class="th-sm">Precio Venta</th>
                  <th class="th-sm">Total Venta</th>
                  <th class="th-sm">Utilidad</th>
                </tr>
              </thead>
              <tbody>';

    foreach ($a as $b) {
      $pcosto = $this->ObtenerPrecioCosto($b["cod"]);
      $pventa = $this->PrecioVenta($b["cod"]);
      $putilidad = ($pventa - $pcosto) * $b['cantidad'];
      $tcosto = $pcosto * $b['cantidad'];
      $tventa = $pventa * $b['cantidad'];

      $cantidad = $cantidad + $b["cantidad"];
      $costo = $costo + $pcosto;
      $venta = $venta + $pventa;

      $costot = $costot + $tcosto;
      $ventat = $ventat + $tventa;
      $utilidad = $utilidad + $putilidad;
      
      echo '<tr>
              <td>'.$n++.'</td>
              <td>'.$b["cod"].'</td>
              <td>'.$b["descripcion"].'</td>
              <td>'.$b["cantidad"].'</td>
              <td>'.Helpers::Dinero($pcosto).'</td>
              <td>'.Helpers::Dinero($tcosto).'</td>
              <td>'.Helpers::Dinero($pventa).'</td>
              <td>'.Helpers::Dinero($tventa).'</td>
              <td>'.Helpers::Dinero($putilidad).'</td>
            </tr>';
    }
    echo '</tbody>
    </table>';


    echo '<table class="table table-sm table-striped">
    <thead>
      <tr>
        <th class="th-sm">TOTAL PRODUCTOS</th>
        <th class="th-sm">TOTAL COSTO</th>
        <th class="th-sm">TOTAL VENTA</th>
        <th class="th-sm">UTILIDAD PROYECTADA</th>
      </tr>
    </thead>
    <tbody>';

    $venta = $venta * $cantidad;
    echo '<tr>
            <td>'.$cantidad.'</td>
            <td>'.Helpers::Dinero($costot).'</td>
            <td>'.Helpers::Dinero($ventat).'</td>
            <td>'.Helpers::Dinero($utilidad).'</td>
          </tr>';
  
    echo '</tbody>
    </table>';

   } $a->close();



  }




    public function ObtenerPrecioCosto($cod) { // obtine cantiad de productos
        $db = new dbConn();
   
        $precio = 0;
      
        if ($r = $db->select("precio_costo", "producto_ingresado", "WHERE producto = '".$cod."' and td = ". $_SESSION["td"] ." order by id desc limit 1")) { 
            $precio = $r["precio_costo"];
        } unset($r);  
        
            return $precio;
      }
      


      public function PrecioVenta($cod) { // obtine cantiad de productos
        $db = new dbConn();
      
      $precio = 0;
      
      if ($r = $db->select("precio", "producto_precio", "WHERE cant = 1 and producto = '".$cod."' and td = ". $_SESSION["td"] ."")) { 
          $precio = $r["precio"];
      } unset($r);  
      
          return $precio;
      }
      




} // Termina la lcase