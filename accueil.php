<?php
include_once('modele/connexion_base.php');
include_once('modele/accueil.php');

if(isset($_POST['login']) && isset($_POST['passe']))
{
	if(connexion($_POST['login'], sha1($_POST['passe'])))
	{
		$user=getInformation($_POST['login']);
		setcookie('id', $user['id']);
		setcookie('nom', $user['nom']);
		setcookie('idEcole', $user['idEcole']);
		setcookie('id_region', $user['id_region']);
		setcookie('id_prefecture', $user['id_prefecture']);
		setcookie('login', $user['login']);
		setcookie('nom_fonction', $user['nom_fonction']);
		header('location: index.php');
	}
	else
	{
		setcookie('echec_connexion', 'oui', time()+3);
		header('location: index.php');
	}	
}

include_once('vue/accueil.php');
