<?php
include_once('modele/connexion_base.php');
include_once('modele/salaire.php');
include_once('fonction.php');

$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];

$jourActuel=date('d');
$moisActuel=date('m');
$anneeActuel=date('Y');

$observation='';
if(isset($_COOKIE['salaire']))
	$observation=$_COOKIE['salaire'];

if(isset($_POST['idPersonnel']) && isset($_POST['jour']) && !empty($_POST['jour']) && isset($_POST['mois']) && !empty($_POST['mois']) && 
	isset($_POST['annee']) && !empty($_POST['annee']) && isset($_POST['moisAPayer']) &&
	isset($_POST['salaire']) && !empty($_POST['salaire']) && isset($_POST['taux']) && !empty($_POST['taux']) && 
	isset($_POST['volume']) && !empty($_POST['volume']))
{
	$jour=(int)$_POST['jour'];
	$mois=(int)$_POST['mois'];
	$annee=(int)$_POST['annee'];
	$salaire=(int)$_POST['salaire'];
	$taux=(int)$_POST['taux'];
	$volume=(int)$_POST['volume'];
	$idPersonnel=$_POST['idPersonnel'];
	$moisAPayer=(int)$_POST['moisAPayer'];
	
	if(checkdate($mois, $jour, $annee))
	{
		$date=$annee.'-'.$mois.'-'.$jour;
		insertSalaire($idPersonnel, $date, $mois, $salaire, $taux, $volume, $_SESSION['annee']);
		setcookie('salaire', 'succes', time()+3);
	}
	else
	{
		setcookie('salaire', 'echec', time()+3);
	}
	
	header('location: salaire.php');
}
else
	setcookie('salaire', 'echec', time()+3);

include_once('vue/salaire.php');
