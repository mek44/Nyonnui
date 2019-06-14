<?php
function insertSalaire($idPersonnel, $date, $mois, $salireBase, $tauxHoraire, $volumeHoraire, $annee)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO salaire(id_personnel, date, mois, salaire_base, taux_horaire, volume_horaire, annee) 
		VALUES(:id_personnel, :date, :mois, :salaire_base, :taux_horaire, :volume_horaire, :annee)');
	$prepare->execute([
			'id_personnel'=>$idPersonnel,
			'date'=>$date,
			'mois'=>$mois,
			'salaire_base'=>$salireBase,
			'taux_horaire'=>$tauxHoraire,
			'volume_horaire'=>$volumeHoraire,
			'annee'=>$annee
		]);
}

if(isset($_GET['matricule']))
{
	session_start();
	include_once('connexion_base.php');
	
	$prepare=$base->prepare('SELECT id, matricule, nom, prenom, photo, fonction, salaire_base AS salaire, taux_horaire AS taux 
		FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	echo json_encode($resultat);
}

