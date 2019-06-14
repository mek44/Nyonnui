<?php
$pageValide=true;
if(isset($_SESSION['user']))
{
	include_once('modele/liste_utilisateur.php');
	include_once('modele/connexion_base.php');
	
	if($_SESSION['user']['nom_fonction']!='Super Administrateur')
		$pageValide=false;
	
	$listeUtilisateur=getListeUtilisateur();
	
	$listeRegion=getRegion();
	$listeFonction=getFonction();
	$listePrefecture=[];
	
	
	if(is_array($listeRegion) && count($listeRegion)>0)
		$listePrefecture=getPrefecture($listeRegion[0]['id']);
	
	$prefecture=null;
	
	if(is_array($listePrefecture) && count($listePrefecture)>0)
		$prefecture=$listePrefecture[0]['id'];
	
	$listeEcole=getEcole($prefecture);
}
else
	$pageValide=false;

include_once('vue/liste_utilisateur.php');