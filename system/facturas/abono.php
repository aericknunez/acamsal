<?php
include_once '../../application/common/Helpers.php'; // [Para todo]
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
$db = new dbConn();
include_once '../../application/includes/DataLogin.php';
$seslog = new Login();
$seslog->sec_session_start();

include_once '../../application/common/Alerts.php';

if ($seslog->login_check() == TRUE) {

   $a = $db->query("SELECT * FROM creditos WHERE hash = '".$_REQUEST["credito"]."' and td = ".$_SESSION["td"]." and tx = ".$_REQUEST["tx"]."");

        $totalregistros =$a->num_rows;
        $datos = "";

    foreach ($a as $b) {
        $datos .= '<tr>
                <td style="text-align:center;">'. $b["cant"] .'</td>
                <td>'. $b["producto"] .'</td>                                
                <td class="text-right">'. $b["pv"] .'</td>
                <td class="text-right">'. $b["total"] .'</td>
            </tr>';
    } $a->close();




// datos generales de la factura
    if ($r = $db->select("fecha, hora, efectivo", "ticket_num", "WHERE num_fac = '".$_REQUEST["factura"]."' and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
        $fecha = $r["fecha"];
        $hora = $r["hora"];
        $efectivo = $r["efectivo"];

        
    } unset($r);  


    if ($r = $db->select("sum(stotal) as stotal, sum(imp) as imp, sum(total) as total", "ticket", "WHERE num_fac = '".$_REQUEST["factura"]."' and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
        $stotal = $r["stotal"];
        $total = $r["total"];
        $imp = $r["imp"];
    } unset($r);  

// OBTENER EL ASOCIADO
    if ($r = $db->select("cliente", "ticket_cliente", "WHERE factura = '".$_REQUEST["factura"]."' and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
        $cliente = $r["cliente"];
    } unset($r);  

    if ($r = $db->select("nombre", "clientes", "WHERE hash = '$cliente' and td = ".$_SESSION["td"]."")) { 
        $nombre = $r["nombre"];
    } unset($r);  




if($totalregistros > 0){
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <title>Imprimir Factura</title>
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="pragma" content="no-cache">
        <link href="../../assets/factura_web/styles.css" rel="stylesheet" type="text/css">
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 1024px; margin: 0 auto; padding-top: 20px; }
            .btn { margin-bottom: 5px; }
            .table { border-radius: 3px; }
            .table th { background: #f5f5f5; }
            .table th, .table td { vertical-align: middle !important; }
            .table { font-size: 9px; }
            h3 { margin: 5px 0; }
            .letras { font-size: 11px; }

            @media print {
                .no-print { display: none; }
                #wrapper { max-width: 1024px; width: 100%; min-width: 250px; margin: 0 auto; }
            }
            tfoot tr th:first-child { text-align: right; }
        </style>
    </head>
    <body>
      <div id="wrapper">
        <div id="receiptData" style="width: auto; max-width: 1024px; min-width: 250px; margin: 0 auto;">

            <div id="receipt-data">
                <div>
                    <div style="text-align:center;">
                        Asociación Cooperativa de aprovisionamiento,comercialización y transporte de mototaxistas salvadoreños

                        <p class="letras" style="text-align:center;">ACAMSAL de RL</p>
                    </div>


                    <p class="letras">COMPROBANTE DE ABONO</strong></p>

                <?php if($nombre != NULL){  ?>
                    <p class="letras">ASOCIADO: <strong><?php echo $nombre; ?></strong></p>
                <?php } ?>
                
                    <p class="letras">FACTURA No: <strong><?php echo str_pad($_REQUEST["factura"], 8, "0", STR_PAD_LEFT); ?></strong></p>

                    <p class="letras">CREDITO OTORGADO: <strong><?php echo $fecha . " || " . $hora; ?></strong></p>

<?php if($_REQUEST["credito"] == TRUE){
    echo '<p class="letras"  style="text-align:center;">LOS SIGUIENTES PRODUCTOS ESTAN PENDIENTES DE PAGO</strong></p>';
} ?>

                    <div style="clear:both;"></div>
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%; border-bottom: 2px solid #ddd;">Cant</th>
                                <th class="text-center" style="width: 60%; border-bottom: 2px solid #ddd;">Descripción</th>
                                
                                <th class="text-right" style="width: 14%; border-bottom: 2px solid #ddd;">Precio</th>
                                <th class="text-right" style="width: 16%; border-bottom: 2px solid #ddd;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 

                         echo $datos;

                         ?>
                                  
                        </tbody>
                        <tfoot>
                            <!-- <tr>
                                <th colspan="2">SubTotal</th>
                                <th colspan="2" class="text-right"><?php echo Helpers::Dinero($stotal) ?></th>
                            </tr> -->
<!--                             <tr>
                                <th colspan="2">IVA</th>
                                <th colspan="2" class="text-right"><?php echo Helpers::Dinero($imp) ?></th>
                            </tr>   -->                                        
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th colspan="2" class="text-right"><?php echo Helpers::Dinero($total) ?></th>
                                </tr>
                        </tfoot>
                    </table>
                    
                    <table class="table table-striped table-condensed" style="margin-top:10px;">
                        <tbody>

                            <?php if($_REQUEST["credito"] != TRUE){ ?>
                            <tr>
                                <td class="text-right">Monto :</td>
                                <td><?php if($efectivo == 0){
                                    echo Helpers::Dinero($total);
                                } else {
                                    echo Helpers::Dinero($efectivo);
                                } ?></td>

                            
                                <td class="text-right">Cambio :</td>
                                <td><?php if($efectivo == 0){
                                    echo Helpers::Dinero(0);
                                } else {
                                   echo Helpers::Dinero($efectivo - $total);
                                }
                                 ?></td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>



<div class="letras" style="text-align: right;">
    Fecha: <?php echo $fecha . " | " . $hora ?></div>

        <?php if($cliente != NULL and $documento != NULL){
            echo '<p>
                 Cliente: '. $cliente .' <br>
                 Documento: '. $documento .'
             </p>';
        } ?>


                    
                                                                                    
<!--     <div class="letras" class="well well-sm" style="margin-top:10px;">
        <div style="text-align: center;">GRACIAS POR SU COMPRA. VUELVA PRONTO</div>
    </div> -->

            
         </div>
                <div style="clear:both;"></div>
            </div>

            <!-- start -->
<div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
<hr>
<span class="pull-right col-xs-12">
<button onclick="window.print();" class="btn btn-block btn-primary">Imprimir</button></span>
<span class="pull-left col-xs-12"><a class="btn btn-block btn-success" href="#" id="email">Email</a></span>
<!-- <span class="col-xs-12">
<a class="btn btn-block btn-warning" href="../../?">Regresar</a>
</span> -->
<div style="clear:both;"></div>
</div>
            <!-- end -->
        </div>
    </div>


<script type="text/javascript" src="../../assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#print').click(function (e) {
                e.preventDefault();
                var link = $(this).attr('href');
                $.get(link);
                return false;
            });

            window.print();
            // window.close();

        });
    </script>
                    



</body></html>

<?php 
} else{
    header("location: ../../error.php");
}

} else {    
    header("location: ../../");
}
 ?>
