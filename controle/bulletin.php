<?php
include_once('modele/bulletin.php');
include_once('modele/connexion_base.php');
include_once('fonction.php');

if(isset($_GET['id']))
{
	$_SESSION['idEleve']=(int)$_GET['id'];
	$trimestre=1;
	$information=getInformation($_SESSION['idEleve'], $_SESSION['annee']);
	$eleve=$information['eleve'];
	$classe=$information['classe'];
	$bulletin=getBulletinTrimestre($_SESSION['idEleve'], $trimestre, $_SESSION['annee']);
	$rang=getRangTrimestre($_SESSION['idEleve'], $_SESSION['annee'], $trimestre);
	$titre=$bulletin['titre'];
	$resultat=$bulletin['resultat'];
	$nombreMois=$bulletin['nombreMois'];
	$totalMois=$bulletin['totalMois'];	
	$niveau=$bulletin['niveau'];

	$coefficientTotal=$bulletin['coefficientTotal'];
	$moyenneGenerale=$bulletin['moyenneGenerale']/($nombreMois*$coefficientTotal);
	$listeAnnee=getListeAnnee($_SESSION['idEleve']);
	$observation=getObservation($classe['niveau'], $moyenneGenerale);
	
	$libelleClasse=$classe['niveau'].'';
/*	if($classe['niveau']!=13)
	{
		$libelleClasse=$classe['niveau'];
		if($classe['niveau']==1)
			$libelleClasse.='ère ';
		else
			$libelleClasse.='ème ';
	}
	else
		$libelleClasse='Terminal';
*/	
	if($classe['niveau']>10)
		$libelleClasse.=$classe['option_lycee'];

	if($classe['niveau']!=13)
		$libelleClasse.='année';

	include_once('vue/bulletin.php');
}

