<div id="areaImprimir">
<?php 

    $d = $db->selectGroup("cliente", "contratos", "WHERE fechaPago = '$dia' GROUP BY cliente");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {

            if ($x = $db->select("cliente, dir_residencia, dir_cobro", "clientes", "WHERE id = ".$r["cliente"]."")) { 
                  $cliente = $x["cliente"];
                  $direccion = $x["dir_residencia"];
                  $direccion2 = $x["dir_cobro"];
              } unset($x);   
           echo '<div class="row">
                        <div class="col-6">
                                <div class="panel-heading">
                                <h3>Cliente: '. $cliente .'</h3>
                                </div>
                                <div class="panel-body"><h3>
                                Dirección: '. $direccion .'
                                </h3></div>

                        </div>

                          <div class="col-6 text-right">
                          <img alt="" src="assets/img/logo/cametpequeno.png"/>
                          </div>
            </div>
            <hr />
             
            <pre>Detalles de cobro</pre>
            <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"><h3>Descripci&oacuten</h3></th>
                    <th scope="col"><h3>Precio</h3></th>
                  </tr>
                </thead>
                <tbody>';
          // despues de agrupar busco las facturas
               $a = $db->query("SELECT * FROM control_facturas WHERE cliente = ".$r["cliente"]." and estado = 1");
               $num= 0;
               $st= 0;
                foreach ($a as $b) {
              $num = $num + 1;
              $st = $st + $b["subtotal"];

                  if ($r = $db->select("servicio", "contratos", "WHERE id = ".$b["contrato"]."")) { 

                        if ($x = $db->select("servicio", "servicios", "WHERE id = ".$r["servicio"]."")) { 
                          $servicio = $x["servicio"];
                      } unset($x);                     
                  } unset($r);  

                    echo '<tr>
                          <th scope="row"><h3>'. $num .'</h3></th>
                          <td><h3>'.  $servicio . ' | Mes: ' . Fechas::MesEscrito($b["mes"]) . '</h3></td>
                          <td><h3>'.$b["subtotal"].'</h3></td>
                        </tr>';
                    //echo $b["cliente"] . "s: " . $b["servicio"] . "<br>"; 
                } $a->close();
                $imp=$b["impuestos"]/100;
                $imp=Helpers::format($st*$imp);
            echo '<tr>
                     <td colspan="2" class="text-right"><h3>Subtotal</h3></td>
                    <th scope="row"><h3>'. Helpers::format($st) .'</h3></th>
                  </tr>
                  <tr>
                     <td colspan="2" class="text-right"><h3>Impuestos</h3></td>
                    <th scope="row"><h3>'. $imp .'</h3></th>
                  </tr>
                  <tr>
                     <td colspan="2" class="text-right"><strong><h3>Total</h3></strong></td>
                    <th scope="row"><strong><h3>' . Helpers::format($st+$imp) . '</h3></strong></th>
                  </tr>
                </tbody>
              </table> <hr>';
                
        } // while
                ?>

              </div>
                  <a onclick="printDiv('areaImprimir')" class="btn-floating btn-sm blue-gradient"><i class="fa fa-print" id="basic"></i></a>

                  <script>
                  function printDiv(nombreDiv) {
                       var contenido= document.getElementById(nombreDiv).innerHTML;
                       var contenidoOriginal= document.body.innerHTML;

                       document.body.innerHTML = contenido;

                       window.print();

                       document.body.innerHTML = contenidoOriginal;
                  } 
                  </script>
                <?
    }$d->close();
$db->close();
?>

<!-- <div id="areaImprimir">
<div class="col-xs-6 text-right">
<h3><a href=" "><img alt="" src="logo.png"/> Logo aquí </a></h3>
</div>
 <div class="panel-heading">
<h4>Cliente: Erick Adonai Nunez Martinez</h4>
</div>
<div class="panel-body">Dirección: detalles más detalles</div>
<hr />
 
<pre>Detalles de cobro</pre>
<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Descripci&oacuten</th>
      <th scope="col">Precio</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Television por cable</td>
      <td>423</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Servicio de internet</td>
      <td>23</td>
    </tr>
    <tr>
       <td colspan="2" class="text-right">Subtotal</td>
      <th scope="row">123</th>
    </tr>
    <tr>
       <td colspan="2" class="text-right">Impuestos</td>
      <th scope="row">123</th>
    </tr>
    <tr>
       <td colspan="2" class="text-right"><strong>Total</strong></td>
      <th scope="row"><strong>123</strong></th>
    </tr>
  </tbody>
</table>
</div>

<a onclick="printDiv('areaImprimir')" class="btn-floating btn-sm blue-gradient"><i class="fa fa-print" id="basic"></i></a>

<script>
function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
} 
</script>
 -->