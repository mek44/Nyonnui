<?php
include_once('modele/connexion_base.php');
include_once('modele/ajouter_region.php');

$observation='';

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];

if(isset($_POST['nom']) && strlen($_POST['nom'])>3 && isset($_SESSION['user']) && 
	($_SESSION['user']['fonction']!='superadministrateur' || $_SESSION['user']['fonction']!='administrateur'))
{
	$nom=htmlspecialchars($_POST['nom']);
	
	if(!isRegionExiste($nom))
	{
		insertRegion($nom);
		setcookie('nouvelle_region', 'La région a été enregistrée avec succès', time()+3);
		setcookie('enregistrement', 'succes', time()+3);
		header('location: ajouter_region.php');
	}
	else
	{
		setcookie('enregistrement', 'echec', time()+3);
		setcookie('nouvelle_region', 'Cette région existe déjà', time()+3);
		header('location: ajouter_region.php');
	}
		
}
else
{
	setcookie('enregistrement', 'echec', time()+3);
	setcookie('nouvelle_region', 'Les données ne sont pas valides', time()+3);
}
	

include_once('vue/ajouter_region.php');