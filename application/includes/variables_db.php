<?php
date_default_timezone_set('America/El_Salvador');

if(Helpers::ServerDomain() == TRUE){

define("HOST", "db5001821033.hosting-data.io"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "dbu678928"); 			// The database username. 
define("PASSWORD", "Caca007125-"); 	// The database password.
define("DATABASE", "dbs1499012");


} else {

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "root"); 			// The database username. 
define("PASSWORD", "erick"); 	// The database password. 
define("DATABASE", "acamsal"); 

}

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);    // For development purposes only!!!!

// para el sistema
define("BASE_URL", "https://pizto.com/acamsal/");
define("BASEPATH", "https://pizto.com/acamsal/");	

?>