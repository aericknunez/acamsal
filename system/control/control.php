<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/control/Controles.php';
include_once 'system/corte/Corte.php';
include_once 'application/common/Fechas.php';

$cut = new Corte();

$control = new Controles(); 
?>

<div class="row mb-3">

<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-3 col-3 text-left pl-1">
        <a type="button" class="btn-floating btn-lg secondary-color ml-4 waves-effect waves-light"><i class="fas fa-barcode" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-9 col-9 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo $control->Clave(); ?></h5>
        <p class="font-small grey-text">Codigo</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->




<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-3 col-3 text-left pl-1">
        <a type="button" class="btn-floating btn-lg info-color ml-4 waves-effect waves-light"><i class="fas fa-credit-card" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-9 col-9 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo Helpers::Dinero($cut->GastoHoy(date("d-m-Y"))); ?></h5>
        <p class="font-small grey-text">Gastos</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->


<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-3 col-3 text-left pl-1">
        <a type="button" class="btn-floating btn-lg success-color lighten-1 ml-4 waves-effect waves-light"><i class="fas fa-dollar-sign" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-9 col-9 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo Helpers::Dinero($cut->VentaHoy(date("d-m-Y"))); ?></h5>
        <p class="font-small grey-text">Ventas</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-3 col-3 text-left pl-1">
        <a type="button" class="btn-floating btn-lg red accent-2 ml-4 waves-effect waves-light"><i class="fas fa-money-bill" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-9 col-9 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo Helpers::Dinero($cut->EfectivoDebido(date("d-m-Y"))); ?></h5>
        <p class="font-small grey-text">Efectivo</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->

</div>







<!-- division -->


<div class="row mt-3">

<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-3 col-3 text-left pl-1">
        <a type="button" class="btn-floating btn-lg secondary-color ml-4 waves-effect waves-light"><i class="far fa-chart-bar" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-9 col-9 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo Helpers::Format($control->TotalProductos()); ?></h5>
        <p class="font-small grey-text">Productos</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->




<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-5 col-5 text-left pl-1">
        <a type="button" class="btn-floating btn-lg success-color ml-4 waves-effect waves-light"><i class="fas fa-chart-line" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-7 col-7 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo $cut->ProductosHoy(date("d-m-Y")); ?></h5>
        <p class="font-small grey-text">Vendidos</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->


<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-5 col-5 text-left pl-1">
        <a type="button" class="btn-floating btn-lg light-blue lighten-1 ml-4 waves-effect waves-light"><i class="fas fa-grin-beam" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-7 col-7 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo $cut->ClientesHoy(date("d-m-Y")); ?></h5>
        <p class="font-small grey-text">Clientes</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card">
    <div class="row mt-3">
      <div class="col-md-5 col-5 text-left pl-1">
        <a type="button" class="btn-floating btn-lg red accent-2 ml-4 waves-effect waves-light"><i class="fas fa-sliders-h" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-7 col-7 text-right pr-4">
        <h5 class="ml-4 mt-4 mb-2 font-weight-bold"><?php echo Helpers::Dinero($cut->TotalAbonos(date("d-m-Y"))); ?></h5>
        <p class="font-small grey-text">Abonos</p>
      </div>
    </div>

  </div>
</div>
<!-- Grid column -->

</div>
<canvas id="barChart" class="mb-4"></canvas>




