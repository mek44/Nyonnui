<?php
function getClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function isMatriculeExist($matricule)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM eleve WHERE id_ecole=:id_ecole AND matricule=:matricule');
	$prepare->execute(array(
		'id_ecole'=>$_SESSION['user']['idEcole'],
		'matricule'=>$matricule));
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	if($resultat['nombre']<1)
		return false;
	else
		return true;
}


function updateTuteur(array $tuteur, $matricule, $idEcole)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE tuteur SET nom=:nom, adresse=:adresse, telephone=:telephone 
		WHERE id=(SELECT id_tuteur FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole)');
	$prepare->execute([
			'nom'=>$tuteur['nomTuteur'],
			'adresse'=>$tuteur['adresse'],
			'telephone'=>$tuteur['telephone'],
			'matricule'=>$matricule,
			'id_ecole'=>$idEcole
		]);
}


function updateEleve(array $eleve, $cours, $annee)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE eleve SET pv_dernier_examen=:pv_dernier_examen, rang_dernier_examen=:rang_dernier_examen, 
		session_dernier_examen=:session_cache_expire WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'pv_dernier_examen'=>$eleve['pv_dernier_examen'],
			'rang_dernier_examen'=>$eleve['rang_dernier_examen'],
			'session_dernier_examen'=>$eleve['session_dernier_examen'],
			'id_ecole'=>$eleve['id_ecole'],
			'matricule'=>$eleve['matricule']
		]);
	
	$prepare=$base->prepare('INSERT INTO classe_eleve(id_classe, id_eleve, date_inscription, annee) 
		VALUES(:id_classe, (SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole), :date_inscription, :annee)');
	$prepare->execute([
			'id_classe'=>$cours, 
			'matricule'=>$eleve['matricule'],
			'id_ecole'=>$eleve['id_ecole'],
			'date_inscription'=>$eleve['date_inscription'],
			'annee'=>$annee
		]);
}


function updateImage($matricule, $idEcole, $photo)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE eleve SET photo=:photo WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$matricule,
			'id_ecole'=>$idEcole,
			'photo'=>$photo
		]);
}