<?php
include_once('modele/connexion_base.php');
include_once('modele/faire_bon.php');
include_once('fonction.php');

$jour=date('d');
$moisl=date('m');
$annee=date('Y');

$pageValide=false;

if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']==='Comptable')
{
    $pageValide=true;
}

$observation='';
if(isset($_COOKIE['bon']))
	$observation=$_COOKIE['bon'];

if(isset($_POST['idPersonnel']) && isset($_POST['jour']) && !empty($_POST['jour']) && isset($_POST['mois']) && !empty($_POST['mois']) && 
	isset($_POST['annee']) && !empty($_POST['annee']) && isset($_POST['montant']) && !empty($_POST['montant']))
{
    $jour=(int)$_POST['jour'];
    $mois=(int)$_POST['mois'];
    $annee=(int)$_POST['annee'];
    $montant=(int)$_POST['montant'];
    $idPersonnel=$_POST['idPersonnel'];

    if(checkdate($mois, $jour, $annee))
    {
        $date=$annee.'-'.$mois.'-'.$jour;
        insertAvance($idPersonnel, $date, $montant, $_SESSION['annee']);
        setcookie('bon', 'succes', time()+3);
    }
    else
    {
        setcookie('bon', 'echec', time()+3);
    }

    header('location: faire_bon.php');
}

include_once('vue/faire_bon.php');
