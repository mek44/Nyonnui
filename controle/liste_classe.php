<?php
include_once('modele/connexion_base.php');
include_once('modele/liste_classe.php');
include_once('fonction.php');

$pageValide=true;

if(isset($_SESSION['user']))
{
	if($_SESSION['user']['nom_fonction']!='Directeur général' && $_SESSION['user']['nom_fonction']!='Proviseur' && $_SESSION['user']['nom_fonction']!='Principal' &&
			$_SESSION['user']['nom_fonction']!='Directeur')
		$pageValide=false;
	
	$effectifTotal=getEffectifTotal($_SESSION['user']['idEcole'], $_SESSION['annee']);
	$listeClasse=getEffectifParClasse($_SESSION['user']['idEcole'], $_SESSION['annee']);

	$listeHeure=[8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];
	$listeMinute=[0, 10, 20, 30, 40, 50];

	$listeEleve=[];
	$listeMatiere=[];
	$libelle='';
	$listeJour=['Lundi'=>1, 'Mardi'=>2, 'Mercrédi'=>3, 'Jeudi'=>4, 'Vendredi'=>5, 'Samedi'=>6];
	$idClasseActif=0;
	
	if(count($listeClasse)>0)
	{
		$listeEleve=getListeEleve($listeClasse[0]['id'], $_SESSION['annee']);
		$listeMatiere=getMatiereClasse($listeClasse[0]['id']);
		$listeEmploie=getEmploie($listeClasse[0]['id']);
		$libelle=formatClasse($listeClasse[0]);
		$idClasseActif=$listeClasse[0]['id'];
	}

}
else
	$pageValide=false;

include_once('vue/liste_classe.php');