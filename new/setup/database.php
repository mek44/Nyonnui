<?php

//DATA BASE CREDENTIALS
define('DB_HOST', 'localhost');
if($_SERVER['SERVER_ADDR']=='::1'){
    define('DB_NAME', 'vico');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');    
}else{
    define('DB_NAME', 'u355875060_vico');
    define('DB_USERNAME', 'u355875060_atta');
    define('DB_PASSWORD', 'exT8s6py6nIKHr6LA3');
}
  
try{
	$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}catch(PDOException $e){
	die('Erreur: '.$e->getMessage());
}

?>
