<?php
if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	include_once('modele/connexion_base.php');
	include_once('modele/rapport_salaire.php');
	include_once('fonction.php');
	$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
	$mois=date('m');
	$rapport=getRapport($_SESSION['user']['idEcole'], $mois, $_SESSION['annee']);
	
	$total=0;

	foreach ($rapport as $salaire) 
	{
		$total+=($salaire['volume_horaire']*$salaire['taux_horaire'])+$salaire['salaire_base'];
	}
	include_once('vue/rapport_salaire.php');
}