<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	if($_SESSION['user']['nom_fonction']!='Comptable')
		$pageValide=true;
	
	include_once('modele/connexion_base.php');
	include_once('modele/taux_presence.php');
	include_once('fonction.php');
	
	$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
	$moisActuel=date('m');
	
	$idEcole=0;
	if($_SESSION['user']['nom_fonction']!='Directeur général' && isset($_GET['id_ecole']))
		$idEcole=(int)$_GET['id_ecole'];
	else
		$idEcole=$_SESSION['user']['idEcole'];
		
	$ecole=getNomEcole($idEcole);
	$listeTaux=getTauxPresence($idEcole, $listeMois, $moisActuel, $_SESSION['annee']);
	
}

include_once('vue/taux_presence.php');