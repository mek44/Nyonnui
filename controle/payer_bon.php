<?php
include_once('modele/connexion_base.php');
include_once('modele/payer_bon.php');
include_once('fonction.php');

$jour=date('d');
$moisl=date('m');
$annee=date('Y');

$pageValide=false;
$info=[];
$idBon=0;

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général') && isset($_GET['id']))
{
    $pageValide=true;
    $idBon=(int)$_GET['id'];
    $info= getInfo($idBon);
}

$observation='';
if(isset($_COOKIE['payer_bon']))
	$observation=$_COOKIE['payer_bon'];

if(isset($_POST['idBon']) && isset($_POST['verser']) && !empty($_POST['verser']))
{
    $verser=(int)$_POST['verser'];
    $idBon=(int)$_POST['idBon'];

    payerBon($idBon, $verser);
    setcookie('payer_bon', 'succes', time()+3);

    header('location: payer_bon.php?id='.$idBon);
}

include_once('vue/payer_bon.php');
