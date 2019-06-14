<?php
try
{
    if ($_SERVER['SERVER_ADDR']=='::1') {
        $base=new PDO('mysql:host=localhost;dbname=vico','root','');
        $base->exec("SET NAMES 'UTF8'");
    }else{
	$base=new PDO('mysql:host=localhost;dbname=u355875060_vico', 'u355875060_atta', 'exT8s6py6nIKHr6LA3');
    }
}
catch(Exception $e)
{
	die($e->getMessage());
}