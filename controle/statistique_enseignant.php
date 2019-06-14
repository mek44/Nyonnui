<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	include_once('modele/connexion_base.php');
	include_once('modele/statistique_enseignant.php');
	
	$mois=date('m');
	$annee=date('Y');
	$jour=date('d');
	
	if($_SESSION['user']['nom_fonction']!='Comptable')
		$pageValide=true;
	
	$listeRegion=getRegion();
	$listePrefecture=[];
	if($_SESSION['user']['nom_fonction']=='Responsable Régionale')
		$listePrefecture=getPrefecture($_SESSION['user']['id_region']);
	else if(count($listeRegion)>0)
		$listePrefecture=getPrefecture($listeRegion[0]['id']);
		
	$region=count($listeRegion)>0?$listeRegion[0]['id']:null;
	$prefecture=count($listeRegion)>0?$listePrefecture[0]['id']:null;
	
		
	if($_SESSION['user']['nom_fonction']=='DPE / DCE' || $_SESSION['user']['nom_fonction']=='Directeur général')
	{
		$region=$_SESSION['user']['id_region'];
		$prefecture=$_SESSION['user']['id_prefecture'];
	}
		
	$statistique=getStatistique($_SESSION['user'], $prefecture, $jour, $mois, $annee, $_SESSION['annee']);

	include_once('vue/statistique_enseignant.php');
	
}