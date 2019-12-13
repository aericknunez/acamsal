
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
           Cambiar Password</h5>
      </div>
      <div class="modal-body">

<?php 
$usuario = sha1($_REQUEST["user"]);

if($_SESSION["user"]==$usuario){

echo ' <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
      
      Cambiar Password
      
      <form name="form-changepass" method="post" id="form-changepass">
      <input type="password" class="my-1 form-control" id="pass1" name="pass1" placeholder="Nuevo Password" required autocomplete="off">
      <input type="password" class="my-1 form-control" id="pass2" name="pass2" placeholder="Repetir Password" required autocomplete="off">
      <input name="form-changepass" type="submit" id="btn-changepass" value="Cambiar" class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-1 waves-effect">
      </form> 

    </div>
  </div>'; 
} else {
  echo "No tiene permitido cambiar este password";
}



 ?>
 

<div id="msj"></div>
<!-- Default form contact -->

      </div>
      
      <div class="modal-footer">
        <a href="?user" class="btn btn-primary btn-rounded">Regresar</a>
      </div>

    </div>
  </div>
</div>