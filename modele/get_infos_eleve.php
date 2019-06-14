<?php
session_start();
include_once('connexion_base.php');

if(isset($_GET['matricule']) && isset($_SESSION['user']))
{
	$prepare=$base->prepare('SELECT id, matricule, nom, prenom, sexe, DAY(date_naissance) AS jour, MONTH(date_naissance) AS mois, YEAR(date_naissance) AS annee,
		lieu_naissance, pere, mere, ecole_origine, pv_dernier_examen AS pv, rang_dernier_examen AS rang, session_dernier_examen AS session, photo, 
		id_tuteur FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	$resultat1=$prepare->fetch();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT nom AS nomTuteur, adresse, telephone FROM tuteur WHERE id=?');
	$prepare->execute([$resultat1['id_tuteur']]);
	$resultat2=$prepare->fetch();
	$prepare->closeCursor();

	
	$prepare=$base->prepare('SELECT c.id AS cours, n.Libelle AS niveau, c.intitule, c.option_lycee,  DAY(ce.date_inscription) AS jour_ins, 
		MONTH(ce.date_inscription) AS mois_ins, YEAR(ce.date_inscription) AS annee_ins FROM classe AS c INNER JOIN classe_eleve AS ce ON c.id=ce.id_classe 
                INNER JOIN niveau as n ON n.niveau=c.niveau 
		WHERE ce.id_eleve=? ORDER BY ce.date_inscription DESC LIMIT 1');
	$prepare->execute([$resultat1['id']]);
	$resultat3=$prepare->fetch();
	$prepare->closeCursor();

	$resultat=array_merge($resultat1, $resultat2, $resultat3);
	echo json_encode($resultat);
}


