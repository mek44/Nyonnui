<?php
if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	include_once('modele/connexion_base.php');
	include_once('modele/controle_enseignant.php');
	include_once('fonction.php');
	
	$mois=date('m');
	$annee=date('Y');
	$jour=date('d');
	
	$listeControle=getControle($_SESSION['user']['idEcole'], $jour, $mois, $annee);
	
	include_once('vue/controle_enseignant.php');
}

