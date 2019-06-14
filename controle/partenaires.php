<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	include_once('modele/connexion_base.php');
	include_once('modele/partenaires.php');

	if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='Responsable Régionale' || $_SESSION['user']['nom_fonction']=='DPE / DCE' ||
		$_SESSION['user']['nom_fonction']=='Partenaire')
		$pageValide=true;
	
	$listeCycle=getCycle();
	$listeRegion=getRegion();

	$listePrefecture=[];
	if($_SESSION['user']['nom_fonction']=='Responsable Régionale')
		$listePrefecture=getPrefecture($_SESSION['user']['id_region']);
	else if(count($listeRegion)>0)
		$listePrefecture=getPrefecture($listeRegion[0]['id']);
		
	$region=count($listeRegion)>0?$listeRegion[0]['id']:null;
	$prefecture=count($listePrefecture)>0?$listePrefecture[0]['id']:null;
	
	$listeEcole=[];
	if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='Partenaire')
		$listeEcole=getEcole($_SESSION['annee'], $region, $prefecture, $listeCycle[0]['id']);
	else {
		$listeEcole=getEcole($_SESSION['annee'], $_SESSION['user']['id_region'], $_SESSION['user']['id_prefecture'], $listeCycle[0]['id']);
		$prefecture=$_SESSION['user']['id_prefecture'];
	}
		
	
	$primaire=[];
	$college=[];
	$lycee=[];

	foreach($listeCycle as $cycle)
	{
		if($cycle['libelle']=='Primaire')
			$primaire=getStatistique($prefecture, $cycle['id']);
		else if($cycle['libelle']=='Collège')
			$college=getStatistique($prefecture, $cycle['id']);
		else
			$lycee=getStatistique($prefecture, $cycle['id']);
	}

	include_once('vue/partenaires.php');
}
?>