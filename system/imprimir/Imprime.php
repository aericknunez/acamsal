<?php 
class Imprime {

		public function __construct() { 
     	} 




  public function TodosProductos(){
      $db = new dbConn();

 $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto_categoria.categoria FROM producto INNER JOIN producto_categoria ON producto.categoria = producto_categoria.hash and producto.td = ".$_SESSION["td"]."");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"></th>
            <th class="th-sm">Producto</th>
            <th class="th-sm">Cantidad</th>
            <th class="th-sm">Categoria</th>
            <th class="th-sm d-none d-md-block">Minimo</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

          echo '<tr>
                      <td>'.$b["cod"].'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cantidad"].'</td>
                      <td>'.$b["categoria"].'</td>
                      <td class="d-none d-md-block">'.$b["existencia_minima"].'</td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();
  } // termina productos












  public function BajasExistencias(){
      $db = new dbConn();

 $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto_categoria.categoria FROM producto INNER JOIN producto_categoria ON producto.categoria = producto_categoria.hash and producto.cantidad <= producto.existencia_minima and producto.td = ".$_SESSION["td"]."");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th class="th-sm"></th>
            <th class="th-sm">Producto</th>
            <th class="th-sm">Cantidad</th>
            <th class="th-sm">Categoria</th>
            <th class="th-sm d-none d-md-block">Minimo</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($a as $b) {
        // obtener el nombre y detalles del producto
    if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

          echo '<tr>
                      <td>'.$b["cod"].'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cantidad"].'</td>
                      <td>'.$b["categoria"].'</td>
                      <td class="d-none d-md-block">'.$b["existencia_minima"].'</td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();
  } // termina productos







} // Termina la clase