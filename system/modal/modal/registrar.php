<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Registrar nuevo Usuario</h5>
      </div>
      <div class="modal-body">

        <div id="msj"></div>
        
        <form id="form-registrar" name="form-registrar">
            <input type="text" name="nombre" id="nombre" class="my-2 form-control" placeholder="Nombre"/>
            <input type="text" name="email" id="email" class="my-2 form-control" placeholder="email"/>
            <input type="password" name="password" id="password" class="my-1 form-control" placeholder="Password"/>
            <input type="password" name="confirmpwd" id="confirmpwd" class="my-1 form-control" placeholder="Confirmar Password"/>

<select id="tipo" name="tipo" class="browser-default form-control" required="yes">
    <option value="" disabled selected>Elija una Opcion</option>
    <option <? 
    if($_SESSION['tipo_cuenta'] == 3 or $_SESSION['tipo_cuenta'] == 4 or (Helpers::ServerDomain() == TRUE and $_SESSION['tipo_cuenta'] == 5)) echo "disabled"; ?> value="2"><?php echo Helpers::UserName(2) ?></option>
    <option <? 
    if($_SESSION['tipo_cuenta'] == 3 or (Helpers::ServerDomain() == TRUE and $_SESSION['tipo_cuenta'] == 5)) echo "disabled"; ?> value="3"><?php echo Helpers::UserName(3) ?></option>
    <option <? 
    if($_SESSION['tipo_cuenta'] == 4 or (Helpers::ServerDomain() == TRUE and $_SESSION['tipo_cuenta'] == 5)) echo "disabled"; ?> value="4"><?php echo Helpers::UserName(4) ?></option>
    <option <? 
    if($_SESSION['tipo_cuenta'] != 1) echo "disabled"; ?> value="5"><?php echo Helpers::UserName(5) ?></option>
</select>

            <input type="button" value="Registrar" class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" id="btn-registrar" name="btn-registrar"/> 
        </form>
      </div>
      <div class="modal-footer">

          <a href="?user" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->