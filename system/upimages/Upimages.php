<?php  

class Upimages{

    public function __construct(){

    }

    public function Subir($imagen,$nombre,$tipo,$tamano,$gasto,$descripcion) {
        $db = new dbConn();

  
if($tipo =="image/jpg" || $tipo =="image/jpeg" || $tipo =="image/pjpeg" || $tipo =="image/gif" || $tipo =="image/png") {
 

$cdestino = '../../assets/img/facturas';

    if(!is_dir($cdestino)){
    mkdir($cdestino, 0777);
    chmod($cdestino, 0777);
}


                    $destino=$cdestino . "/" . $nombre;
 
                    # movemos el archivo
                    if(move_uploaded_file($imagen, $destino))
                    {
                        
                                $datos = array();
                                $datos["gasto"] = $gasto;
                                $datos["imagen"] = $nombre;
                                $datos["descripcion"] = $descripcion;
                                $datos["fecha"] = date("d-m-Y");
                                $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
                                $datos["hora"] = date("H:i:s");
                                $datos["td"] = $_SESSION["td"];
                                if ($db->insert("gastos_images", $datos)) {
                                    
                                Alerts::Alerta("success","Agregado Correctamente","Imagen Agregada Correctamente");
                                } 


                    }else{
                        echo "<br>No se ha podido mover el archivo: ".$nombre . "<br>";
                    }
                
            } else{
                echo "<br>".$nombre." - NO es imagen jpg, png o gif <br>";
            }
    

                         
}




function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
    list($imagewidth, $imageheight, $imageType) = getimagesize($image);
    $imageType = image_type_to_mime_type($imageType);
    
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    switch($imageType) {
        case "image/gif":
            $source=imagecreatefromgif($image); 
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source=imagecreatefromjpeg($image); 
            break;
        case "image/png":
        case "image/x-png":
            $source=imagecreatefrompng($image); 
            break;
    }
    imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
    switch($imageType) {
        case "image/gif":
            imagegif($newImage,$thumb_image_name); 
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage,$thumb_image_name,90); 
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage,$thumb_image_name);  
            break;
    }
    chmod($thumb_image_name, 0777);
    return $thumb_image_name;
}




    public function VerImagen($iden) {
        $db = new dbConn();

            if ($r = $db->select("imagen, descripcion", "gastos_images", "WHERE id = '$iden' and td = ".$_SESSION["td"]."")) { 

                echo '<img src="assets/img/facturas/'.$r["imagen"].'" class="img-fluid" alt="Responsive image"> <br>' .$r["descripcion"];
            } unset($r);  

    }








} // class



