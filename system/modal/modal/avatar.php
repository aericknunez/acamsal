<?php 
$usuario = sha1($_REQUEST["user"]);

    if ($r = $db->select("avatar", "login_userdata", "WHERE user = '$usuario'")) { 
        $avat = $r["avatar"];
    } unset($r);
 ?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          CAMBIAR AVATAR</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div id="avatar-select">
  <?php 
  echo '<img src="assets/img/avatar/'.$avat.'" class="img-fluid rounded-circle hoverable mx-auto d-block" alt="alt="avatar mx-auto white">'; 
  ?>
</div>
<br>
<?php 
$images = glob("assets/img/avatar/*.*");  
      foreach($images as $image)  
      { 
    $image = str_replace("assets/img/avatar/", "", $image);
    $opciones='id="cambiar-avatar" op="4" iden="'.$image.'" user="'.$usuario.'"';

    $output .= '<a ' . $opciones .'><img src="assets/img/avatar/' . $image .'" alt="thumbnail" class="img-thumbnail"
  style="width: 75px"></a>';
    
      }  
      echo $output;
?>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?user" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->