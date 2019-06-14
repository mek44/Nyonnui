<?php
include_once('modele/connexion_base.php');
include_once('modele/rapport_payement.php');
include_once('fonction.php');

$moisActuel=date('m');

$pageValide=true;
if(isset($_SESSION['user']))
{
	if($_SESSION['user']['nom_fonction']!='Directeur général' && $_SESSION['user']['nom_fonction']!='Comptable')
		$pageValide=false;
	
	$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
	$listeClasse=getListeClasse($_SESSION['user']['idEcole']);

	
	$listePaye=getListePaye($moisActuel, 0, $listeMois, $_SESSION['user']['idEcole'], $_SESSION['annee']);
	$informationCifp=getInformationCfip($_SESSION['user']['idEcole']);
	
	$total=0;
	$cfip=($informationCifp['part_ong']+$informationCifp['part_ecole'])*count($listePaye);
	$partOng=$informationCifp['part_ong']*count($listePaye);
	$partEcole=$informationCifp['part_ecole']*count($listePaye);
	
	foreach ($listePaye as $paye) {
		$total+=$paye['montant']-$paye['reduction'];
	}
}
else
	$pageValide=false;

include_once('vue/rapport_payement.php');
