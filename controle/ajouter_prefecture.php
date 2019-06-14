<?php
include_once('modele/connexion_base.php');
include_once('modele/ajouter_prefecture.php');

$observation='';

$listeRegion=getRegion();

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];

if(isset($_POST['nom']) && strlen($_POST['nom'])>3 && isset($_POST['region']) && !empty($_POST['region']) && isset($_SESSION['user']) && 
	($_SESSION['user']['fonction']!='superadministrateur' || $_SESSION['user']['fonction']!='administrateur'))
{
	$nom=htmlspecialchars($_POST['nom']);
	$region=(int)$_POST['region'];
	
	if(!isPrefectureExiste($nom))
	{
		insertPrefecture($nom, $region);
		setcookie('nouvelle_prefecture', 'La prefecture a été enregistrée avec succès', time()+3);
		setcookie('enregistrement', 'succes', time()+3);
		header('location: ajouter_prefecture.php');
	}
	else
	{
		setcookie('enregistrement', 'echec', time()+3);
		setcookie('nouvelle_prefecture', 'Cette prefecture existe déjà', time()+3);
		header('location: ajouter_prefecture.php');
	}
		
}
else
{
	setcookie('enregistrement', 'echec', time()+3);
	setcookie('nouvelle_prefecture', 'Les données ne sont pas valides', time()+3);
}
	

include_once('vue/ajouter_prefecture.php');