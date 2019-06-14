<?php
session_start();
include_once('connexion_base.php');

if(isset($_GET['matricule']) && isset($_SESSION['user']))
{
	$prepare=$base->prepare('SELECT matricule, nom, prenom, sexe, DAY(date_naissance) AS jour, MONTH(date_naissance) AS mois, YEAR(date_naissance) AS annee,
		lieu_naissance, quartier, telephone, photo,  DAY(date_engagement) AS jour_ins, MONTH(date_engagement) AS mois_ins, code,
		YEAR(date_engagement) AS annee_ins, fonction, salaire_base AS salaire, taux_horaire AS taux FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	echo json_encode($resultat);
}


