<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
           Modificar</h5>
      </div>
      <div class="modal-body">

<?php 
$usuario = sha1($_REQUEST["user"]);
    if ($r = $db->select("nombre, tipo", "login_userdata", "WHERE user = '$usuario'")) { 
        $name = $r["nombre"]; $type = $r["tipo"];
    }  unset($r); 
  

 ?>

<?php 
if($_SESSION['tipo_cuenta'] == 1 or $_SESSION['tipo_cuenta'] == 2 or $_SESSION["user"]==$usuario){
  ?>
<!-- Default form contact -->
<form id="form-actualizar" name="form-actualizar">
    <label for="nombre" class="grey-text">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" 
    <?php 
        echo 'value="'.$name.'"';
     ?> required="yes" >
 
    <input type="hidden" id="user" name="user" value="<? echo $_REQUEST["user"]; ?>">

<!-- solo para usuarios root o admin -->
<?php 
if($_SESSION['tipo_cuenta'] != 4){
 ?>

<label>Tipo de Cuenta</label>
<select id="tipo" name="tipo" class="browser-default form-control" required="yes">
    <?php 
        if(!isset($_REQUEST["op"])){ echo '<option value="" disabled selected>Elija una Opcion</option>'; } 
     ?>
    <option <? 
    if($type == 2) echo "selected"; 
    if($_SESSION['tipo_cuenta'] == 3 or $_SESSION['tipo_cuenta'] == 4 or $_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="2"><?php echo Helpers::UserName(2) ?></option>
    <option <? 
    if($type == 3) echo "selected";
    if($_SESSION['tipo_cuenta'] == 3 or $_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="3"><?php echo Helpers::UserName(3) ?></option>
    <option <? 
    if($type == 4) echo "selected";
    if($_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="4"><?php echo Helpers::UserName(4) ?></option>
    <option <? 
    if($type == 5) echo "selected";
    if($_SESSION['tipo_cuenta'] == 5 or $_SESSION['tipo_cuenta'] != 1) echo "disabled"; ?> value="5"><?php echo Helpers::UserName(5) ?></option>
</select>
<?php 
}
?>

    <div class="text-center mt-2">
       <button class="btn btn-outline-warning" type="submit" id="btn-actualizar" name="btn-actualizar">Actualizar<i class="fa fa-paper-plane-o ml-2"></i></button>
    </div>
</form>

<?php 
} // del formulario




 ?>
 

<div id="caja_user"></div>
<!-- Default form contact -->

      </div>
      
      <div class="modal-footer">
        '<a href="?user" class="btn btn-primary btn-rounded">Regresar</a>
      </div>

    </div>
  </div>
</div>