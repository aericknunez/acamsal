<?
if(is_numeric($_REQUEST["x"])){

include_once '../common/Helpers.php';
include_once 'variables_db.php';
include_once '../common/Mysqli.php';
$db = new dbConn();
include_once 'DataLogin.php';

$seslog = new Login();
$seslog->sec_session_start();

     $a = $db->query("SELECT hash FROM login_db_sync");
		$data = array();
		$i=0;
 


    while($row = mysqli_fetch_array($a))
    {      
        $hash = $row["hash"];
           $ax = $db->query("SELECT * FROM login_db_user WHERE hash = '$hash' and td = ". $_REQUEST["x"]."");
           if($ax->num_rows > 0){
                    $az = $db->query("SELECT * FROM login_sync WHERE hash = '$hash' and td = ". $_REQUEST["x"]."");
                    if($az->num_rows == 0){
                        $data[$i] = $row;
                        $i++;
                    } $az->close();
           } $ax->close();
    }


 $a->close();

echo json_encode($data);
}
?>