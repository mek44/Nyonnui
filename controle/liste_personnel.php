<?php
include_once('modele/connexion_base.php');
include_once('modele/liste_personnel.php');

$pageValide=false;
$classePrimaire=[];
$classeSecondaire=[];
$listePersonnel=[];
$listeMatiere=[];

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']=='Directeur général' || $_SESSION['user']['nom_fonction']=='Proviseur' ||
	$_SESSION['user']['nom_fonction']=='Principal' || $_SESSION['user']['nom_fonction']=='Directeur'))
{
	$classePrimaire=getNiveauPrimaire($_SESSION['user']['idEcole']);
	$classeSecondaire=getNiveauSecondaire($_SESSION['user']['idEcole']);
	$listePersonnel=getListePersonnel($_SESSION['user']['idEcole']);
	
	if(is_array($classeSecondaire) &&  count($classeSecondaire)>0){
		$listeMatiere=getMatiereClasse($classeSecondaire[0]['id']);
        }
        
	$pageValide=true;
}

include_once('vue/liste_personnel.php');