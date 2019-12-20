<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?control" class="waves-effect arrow-r"><i class="fas fa-tv"></i> Panel de Control </a></li>

<?php } ?>



<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?corte" class="waves-effect arrow-r"><i class="fas fa-user"></i> Corte Diario </a></li>


<?php } } ?>





<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Historial<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?consolidado" class="waves-effect"><i class="fas fa-cogs"></i> Consolidado Diario</a></li>

<li><a href="?vdiario" class="waves-effect"><i class="fas fa-cog"></i> Ventas Diarias</a></li>
<li><a href="?vmensual" class="waves-effect"><i class="fas fa-cogs"></i> Ventas Mensuales</a></li>

<li><a href="?hcortes" class="waves-effect"><i class="fas fa-cogs"></i> Historial de Cortes</a></li>

<li><a href="?gdiario" class="waves-effect"><i class="fas fa-cog"></i> Gastos Diarios</a></li>
<li><a href="?gmensual" class="waves-effect"><i class="fas fa-cogs"></i> Gastos Mensuales</a></li>


<li><a href="?gra_semanal" class="waves-effect"><i class="fas fa-cog"></i> Grafico Semanal</a></li>
<li><a href="?gra_mensual" class="waves-effect"><i class="fas fa-cogs"></i> Grafico Mensual</a></li>
<li><a href="?gra_semestre" class="waves-effect"><i class="fas fa-cogs"></i> Grafico Semestral</a></li>
<li><a href="?gra_clientes" class="waves-effect"><i class="fas fa-cogs"></i> Grafico de Clientes</a></li>

</ul>
</div>
</li>

<?php } ?>




<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Movimientos de Efectivo<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?gastos" class="waves-effect"><i class="fas fa-cog"></i> Gastos y Compras</a></li>
<li><a href="?entradas" class="waves-effect"><i class="fas fa-cogs"></i> Entrada de Efectivo</a></li>

</ul>
</div>
</li>

<?php } } ?>









<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-calculator"></i> Productos<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">


<?php if($_SESSION["tipo_cuenta"] != 4) { 
?>
<li><a href="?proadd" class="waves-effect"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
<li><a href="?proup" class="waves-effect"><i class="fas fa-pencil-alt"></i> Actualizar Producto</a></li>
<li><a href="?proagregar" class="waves-effect"><i class="fas fa-columns"></i> Agregar Productos</a></li>
<li><a href="?proaverias" class="waves-effect"><i class="fas fa-database"></i> Descontar Averias</a></li>

<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<li><a href="?proopciones" class="waves-effect arrow-r"><i class="fas fa-handshake"></i> Opciones</a></li>
<?php  } ?>

<?php  } ?>
<li><a href="?productos" class="waves-effect"><i class="fas fa-address-book"></i> Todos los productos</a></li>
<!-- <li><a href="?" class="waves-effect"><i class="fas fa-database"></i> Cambios</a></li>
<li><a href="?" class="waves-effect arrow-r"><i class="fas fa-database"></i> Devoluciones</a></li> -->

<li><a href="?bajasexistencias" class="waves-effect"><i class="fas fa-address-book"></i> Bajas Existencias</a></li>
</ul>
</div>
</li>




<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> Asociados<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?cuotas" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Todas las cuotas</a></li>
<li><a href="?cuotaspendientes" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Cuotas Pendientes</a></li>
<li><a href="?asociadoadd" class="waves-effect"><i class="fas fa-user"></i> Agrega Asociado</a></li>
<li><a href="?asociadover" class="waves-effect"><i class="fas fa-address-book"></i> Ver Asociado</a></li>
<li><a href="?asociaunidades" class="waves-effect"><i class="fas fa-address-book"></i> Ver Unidades</a></li>
<li><a href="?contribucionadd" class="waves-effect"><i class="fas fa-address-book"></i> Contribuciones</a></li>

</ul>
</div>
</li>





<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> Conductores<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?conductoradd" class="waves-effect"><i class="fas fa-user"></i> Agrega Conductor</a></li>
<li><a href="?verconductores" class="waves-effect"><i class="fas fa-address-book"></i> Ver Conductores</a></li>
<li><a href="?con_vencidos" class="waves-effect"><i class="fas fa-address-book"></i> Documentos Vencidos</a></li>

</ul>
</div>
</li>




<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-columns"></i> Cotizaciones <i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?cotizar" class="waves-effect"><i class="fas fa-columns"></i> Nueva Cotizaci&oacuten </a></li>
<li><a href="?cotizaciones" class="waves-effect"><i class="fas fa-address-book"></i> Ver Cotizaciones </a></li>
</ul>
</div>
</li>







<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-money-bill-alt"></i> Creditos<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?creditos" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Buscar Credito</a></li>
<li><a href="?creditospendientes" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Creditos Pendientes</a></li>
</ul>
</div>
</li>
<?php } } ?>








<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> Clientes<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?clienteadd" class="waves-effect"><i class="fas fa-user"></i> Agrega Cliente</a></li>
<li><a href="?clientever" class="waves-effect"><i class="fas fa-address-book"></i> Ver Cliente</a></li>

</ul>
</div>
</li>




<?php if($_SESSION["tipo_cuenta"] != 4) {  ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> Proveedores<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?proveedoradd" class="waves-effect"><i class="fas fa-user"></i> Agrega Proveedor</a></li>
<li><a href="?proveedorver" class="waves-effect"><i class="fas fa-barcode"></i> Ver Proveedores</a></li>

</ul>
</div>
</li>

<?php } ?>








<?php if($_SESSION["tipo_cuenta"] != 4) {  /// planilla?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> Planilla<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?planillasver" class="waves-effect"><i class="fas fa-search"></i> Ver Planillas</a></li>
<li><a href="?addempleado" class="waves-effect"><i class="fas fa-user"></i> Agrega Empleado</a></li>
<li><a href="?verempleado" class="waves-effect"><i class="fas fa-barcode"></i> Ver Empleados</a></li>
<li><a href="?descuentos" class="waves-effect"><i class="fas fa-search"></i> Aplicar Descuentos</a></li>

</ul>
</div>
</li>

<?php } ?>






<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Facturas<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a  class="waves-effect"><i class="fas fa-cog"></i> Opciones</a></li>
<li><a  class="waves-effect"><i class="fas fa-cogs"></i> Imprimir Facturas</a></li>

</ul>
</div>
</li>






<?php  
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Configuraciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>
<li><a href="?tablas" class="waves-effect"><i class="fas fa-cogs"></i> Tablas a respaldar</a></li>
<?php } ?>

<li><a href="?user" class="waves-effect arrow-r"><i class="fas fa-user"></i> Usuarios </a></li>

<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<?php } ?>
</ul>
</div>
</li>

<?php  } ?>



<!-- 
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Opciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Respaldos</a></li>

</ul>
</div>
</li> -->








<li><a href="application/includes/logout.php" class="waves-effect arrow-r"><i class="fas fa-power-off"></i> Salir </a></li>

</ul>
</li>