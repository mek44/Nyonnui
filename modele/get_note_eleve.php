<?php
session_start();
include_once('connexion_base.php');

if(isset($_GET['matricule']) && isset($_GET['mois']) && isset($_GET['matiere']) && isset($_SESSION['user']))
{
	$matricule=htmlspecialchars($_GET['matricule']);
	$mois=(int)$_GET['mois'];
	$matiere=(int)$_GET['matiere'];
	
	$prepare=$base->prepare('SELECT valeur FROM note WHERE id_eleve=(SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole) AND 
		id_matiere=:id_matiere AND mois=:mois AND annee=:annee');
	
	$note=0;
	$prepare->execute([
			'matricule'=>$matricule,
			'id_ecole'=>$_SESSION['user']['idEcole'],
			'id_matiere'=>$matiere,
			'mois'=>$mois,
			'annee'=>$_SESSION['annee']
		]);
	if($donnee=$prepare->fetch())
		$note=$donnee['valeur'];
	
	echo str_replace('.', ',', $note);
}