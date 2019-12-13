<?php
include_once 'application/common/Helpers.php'; // [Para todo]
include_once 'application/includes/variables_db.php';
include_once 'application/common/Mysqli.php';
include_once 'application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();


if ($seslog->login_check() == TRUE) {
    include_once 'catalog/index.php';
} else {
	
	if(isset($_REQUEST["change"])){
		if($_SESSION["inicio"] == NULL){
			$_SESSION["inicio"] = 1;
		} else {
			unset($_SESSION["inicio"]);
		}
	 header("location: ./");
	}
    //include_once 'catalog/login.php';
    	if(Helpers::ServerDomain() == FALSE){
		  		if($_SESSION["inicio"] == NULL){
					include_once 'catalog/login_user.php';
				} else {
					include_once 'catalog/login.php';
				}
		} else {
			include_once 'catalog/login.php';
		}   

}
/////////
$db->close();
?>