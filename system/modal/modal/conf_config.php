<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Datos necesarios para el funcionamiento del sistema</h5>
      </div>
      <?php if(isset($_REQUEST["inicio"])){
        include_once 'application/common/Alerts.php';
        $alert = new Alerts();
        $alert->Mensaje("Debe llenar los datos nececesarios para poder usar el sistema correctamente","danger",$boton,$boton2);
      } ?>
      

      <div class="modal-body">

<!-- ./  content -->
<div id="ventana"></div>

    <table class="table table-sm table-striped">
   <tbody>
<form class="text-center border border-light p-5" id="form-config" name="form-config">

    <?
$r = $db->select("*", "config_master", "where td = ".$_SESSION['td']."")
?>
  <tr>
       <td><small id="sistema" class="form-text text-muted mb-1">
        Nombre del Sistema
    </small><input type="text" id="sistema" name="sistema" class="form-control mb-1" placeholder="Sistema" value="<? echo $r["sistema"]; ?>"></td>
       <td><small id="cliente" class="form-text text-muted mb-1">
        Nombre del Negocio (OBLIGATORIO)
    </small><input type="text" id="cliente" name="cliente" class="form-control mb-1" placeholder="Nombre del Negocio" value="<? echo $r["cliente"]; ?>"></td>
  </tr>


  <tr>
       <td><small id="slogan" class="form-text text-muted mb-1">
        Slogan
    </small><input type="text" id="slogan" name="slogan" class="form-control mb-1" placeholder="Slogan" value="<? echo $r["slogan"]; ?>"></td>
       <td><small id="propietario" class="form-text text-muted mb-1">
        Propietario
    </small><input type="text" id="propietario" name="propietario" class="form-control mb-1" placeholder="Propietario" value="<? echo $r["propietario"]; ?>"></td>
  </tr>

  <tr>
       <td><small id="telefono" class="form-text text-muted mb-1">
        Telefono
    </small><input type="text" id="telefono" name="telefono" class="form-control mb-1" placeholder="Telefono" value="<? echo $r["telefono"]; ?>"></td>
       <td><small id="direccion" class="form-text text-muted mb-1">
        Direcci&oacuten
    </small><input type="text" id="direccion" name="direccion" class="form-control mb-1" placeholder="Direccion" value="<? echo $r["direccion"]; ?>"></td>
  </tr>

  <tr>
       <td><small id="email" class="form-text text-muted mb-1">
        Email
    </small><input type="text" id="email" name="email" class="form-control mb-1" placeholder="Email" value="<? echo $r["email"]; ?>"></td>
       <td><small id="pais" class="form-text text-muted mb-1">
        Pais (OBLIGATORIO)
    </small>
    <select id="pais" name="pais" class="browser-default form-control" required="yes">
    <option value="" disabled <? if($r["pais"] == NULL) echo "selected" ?>>Pais</option>
    <option value="1" <? if($r["pais"] == 1) echo "selected" ?>>El Salvador</option>
    <option value="2" <? if($r["pais"] == 2) echo "selected" ?>>Honduras</option>
    <option value="3" <? if($r["pais"] == 3) echo "selected" ?>>Guatemala</option> 
    </select>
  </td>
  </tr>

  <tr>
       <td><small id="giro" class="form-text text-muted mb-1">
        Giro
    </small><input type="text" id="giro" name="giro" class="form-control mb-1" placeholder="Giro" value="<? echo $r["giro"]; ?>"></td>
       <td><small id="nit" class="form-text text-muted mb-1">
        NIT o RTN
    </small><input type="text" id="nit" name="nit" class="form-control mb-1" placeholder="NIT" value="<? echo $r["nit"]; ?>"></td>
  </tr>

  <tr>

    <td><small id="imp" class="form-text text-muted mb-1">
        Impuestos
    </small><input type="text" id="imp" name="imp" class="form-control mb-1" placeholder="Impuestos" value="<? echo $r["imp"]; ?>"></td>
          <td><small id="otras_ventas" class="form-text text-muted mb-1">
        Otras Ventas
    </small>
    <select class="browser-default custom-select" id="otras_ventas" name="otras_ventas">
  <option <? if($r["otras_ventas"] == 0) echo "selected"; ?> value="0">Inactivo</option>
  <option <? if($r["otras_ventas"] == 1) echo "selected"; ?> value="1">Activo</option>
    </select></td>

  </tr>

  <tr>
       <td><small id="tipo_inicio" class="form-text text-muted mb-1">
        Tipo Inicio Venta
    </small>
    <select class="browser-default custom-select" id="tipo_inicio" name="tipo_inicio">
  <option <? if($r["tipo_inicio"] == 1) echo "selected"; if($_SESSION["tipo_cuenta"] != 1) echo "disabled";?> value="1">Venta por Codigo</option>
  <option <? if($r["tipo_inicio"] == 2) echo "selected"; if($_SESSION["tipo_cuenta"] != 1) echo "disabled";?> value="2">Venta Busquedas</option>
    </select></td>

       <td><small id="inicio_tx" class="form-text text-muted mb-1">
        Inicio Tx Factura
    </small>
    <select class="browser-default custom-select" id="inicio_tx" name="inicio_tx">
  <option <? if($r["inicio_tx"] == 0) echo "selected"; ?> value="0">Sin Facturar</option>
  <option <? if($r["inicio_tx"] == 1) echo "selected"; ?> value="1">Facturando</option>
    </select></td>
  </tr>



     <tr>
       <td><select class="browser-default custom-select" id="skin" name="skin">
  <option <? if($r["skin"] == "white-skin") echo "selected"; ?> value="white-skin">Blanco</option>
  <option <? if($r["skin"] == "mdb-skin") echo "selected"; ?> value="mdb-skin">MDB</option>
  <option <? if($r["skin"] == "grey-skin") echo "selected"; ?> value="grey-skin">Gris</option>
  <option <? if($r["skin"] == "pink-skin") echo "selected"; ?> value="pink-skin">Rosado</option>
  <option <? if($r["skin"] == "light-blue-skin") echo "selected"; ?> value="light-blue-skin">Celeste</option>
  <option <? if($r["skin"] == "black-skin") echo "selected"; ?> value="black-skin">Negro</option>
  <option <? if($r["skin"] == "cyan-skin") echo "selected"; ?> value="cyan-skin">Cyan</option>
  <option <? if($r["skin"] == "navy-blue-skin") echo "selected"; ?> value="navy-blue-skin">Azul Marino</option>
    </select></td>
       <td><? echo $r["imagen"]; ?></td>
       
     </tr>

  <tr>
    <td>
      <div class="switch">
            <label>
             Permitir TX ||  Off
              <input type="checkbox" <?php if($r["cambio_tx"] == "on") echo "checked"; ?> id="cambio_tx" name="cambio_tx" >
              <span class="lever"></span> On 
            </label>
          </div>
    </td>
    <td>
    <button class="btn btn-info my-4" type="submit" id="btn-config" name="btn-config">Realizar Cambios</button>
  
    </td>
  </tr>

<?
 unset($r);  

   ?>
   </tbody>
</table>

</form>
<!-- ./  content -->
      </div>
      <div class="modal-footer">
          <?php if($_SESSION['nodatainicial'] == NULL){
            echo '<a href="?configuraciones" class="btn btn-primary btn-rounded">Regresar</a>';
          } else {
            echo '<a href="application/includes/logout.php" class="btn btn-primary btn-rounded">Cerrar Sessi&oacuten</a>';
          } ?>
          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->
