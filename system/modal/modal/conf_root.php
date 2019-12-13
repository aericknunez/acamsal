<?php 
include_once 'application/common/Encrypt.php';

?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Configuraciones del sistema</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div id="ventana"></div>

    <table class="table table-sm table-striped">
   <tbody>
<form class="text-center border border-light p-5" id="form-root" name="form-root">

    <?
$r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."")
?>
  <tr>
       <td><small id="expira" class="form-text text-muted mb-1">
        Expira
    </small><input type="text" id="expira" name="expira" class="form-control mb-1" placeholder="Expira" value="<? echo Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']); ?>"></td>
    
    <td><small id="plataforma" class="form-text text-muted mb-1">
        Plataforma
    </small>
    <select class="browser-default custom-select" id="plataforma" name="plataforma">
  <option <? if(Encrypt::Decrypt($r["plataforma"],$_SESSION['secret_key']) == 1) echo "selected"; ?> value="1">Web</option>
  <option <? if(Encrypt::Decrypt($r["plataforma"],$_SESSION['secret_key']) == 0) echo "selected"; ?> value="0">Local</option>
  </select></td>
     
  </tr>


  <tr>
       <td><small id="ftp_servidor" class="form-text text-muted mb-1">
        Servidor FTP
    </small><input type="text" id="ftp_servidor" name="ftp_servidor" class="form-control mb-1" placeholder="Servidor FTP" value="<? echo Encrypt::Decrypt($r["ftp_servidor"],$_SESSION['secret_key']); ?>"></td>
       <td><small id="ftp_path" class="form-text text-muted mb-1">
        Carpeta del archivo local
    </small><input type="text" id="ftp_path" name="ftp_path" class="form-control mb-1" placeholder="Carpeta" value="<? echo Encrypt::Decrypt($r["ftp_path"],$_SESSION['secret_key']); ?>"></td>
  </tr>

  <tr>
       <td><small id="ftp_ruta" class="form-text text-muted mb-1">
        Ruta de carpeta FTP
    </small><input type="text" id="ftp_ruta" name="ftp_ruta" class="form-control mb-1" placeholder="Ruta FTP" value="<? echo Encrypt::Decrypt($r["ftp_ruta"],$_SESSION['secret_key']); ?>"></td>
       <td><small id="ftp_user" class="form-text text-muted mb-1">
        Usuario FTP
    </small><input type="text" id="ftp_user" name="ftp_user" class="form-control mb-1" placeholder="Usuario FTP" value="<? echo Encrypt::Decrypt($r["ftp_user"],$_SESSION['secret_key']); ?>"></td>
  </tr>

  <tr>
       <td><small id="ftp_password" class="form-text text-muted mb-1">
        Password FTP
    </small><input type="text" id="ftp_password" name="ftp_password" class="form-control mb-1" placeholder="Password FTP" value="<? echo Encrypt::Decrypt($r["ftp_password"],$_SESSION['secret_key']); ?>"></td>
       
      <td><small id="tipo_sistema" class="form-text text-muted mb-1">
        Tipo de Sistema
    </small>
    <select class="browser-default custom-select" id="tipo_sistema" name="tipo_sistema">
  <option <? if(Encrypt::Decrypt($r["tipo_sistema"],$_SESSION['secret_key']) == 0) echo "selected"; ?> value="0">Demo</option>
  <option <? if(Encrypt::Decrypt($r["tipo_sistema"],$_SESSION['secret_key']) == 1) echo "selected"; ?> value="1">Basico</option>
  <option <? if(Encrypt::Decrypt($r["tipo_sistema"],$_SESSION['secret_key']) == 2) echo "selected"; ?> value="2">Profesional</option>
  <option <? if(Encrypt::Decrypt($r["tipo_sistema"],$_SESSION['secret_key']) == 3) echo "selected"; ?> value="3">Corporativo</option>
    </select></td>
     
  </tr>

  <tr>
        <td><button class="btn btn-info my-4" type="submit" id="btn-root" name="btn-root">Realizar Cambios</button></td>
  </tr>

  
<?
 unset($r);  

   ?>
   </tbody>
</table>
<!-- <button class="btn btn-info my-4" type="submit" id="btn-root" name="btn-root">Realizar Cambios</button> -->

</form>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?root" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->