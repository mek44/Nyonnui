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


function updateEleve(array $eleve, $annee)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE eleve SET nom=:nom, prenom=:prenom, sexe=:sexe, date_naissance=:date_naissance, lieu_naissance=:lieu_naissance,
		pere=:pere, mere=:mere, pv_dernier_examen=:pv_dernier_examen, rang_dernier_examen=:rang_dernier_examen, 
		session_dernier_examen=:session_dernier_examen WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'nom'=>$eleve['nom'],
			'prenom'=>$eleve['prenom'],
			'sexe'=>$eleve['sexe'],
			'date_naissance'=>$eleve['date_naissance'],
			'lieu_naissance'=>$eleve['lieu_naissance'],
			'pere'=>$eleve['pere'],
			'mere'=>$eleve['mere'],
			'pv_dernier_examen'=>$eleve['pv_dernier_examen'],
			'rang_dernier_examen'=>$eleve['rang_dernier_examen'],
			'session_dernier_examen'=>$eleve['session_dernier_examen'],
			'id_ecole'=>$eleve['id_ecole'],
			'matricule'=>$eleve['matricule']
		]);
	
	$prepare=$base->prepare('UPDATE classe_eleve SET id_classe=:id_classe, date_inscription=:date_inscription 
		WHERE id_eleve=(SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole) AND annee=:annee');
	$prepare->execute([
			'id_classe'=>$eleve['cours'], 
			'date_inscription'=>$eleve['date_inscription'],
			'matricule'=>$eleve['matricule'],
			'id_ecole'=>$eleve['id_ecole'],
			'annee'=>$annee
		]);
		
	$prepare=$base->prepare('SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$eleve['matricule'],
			'id_ecole'=>$eleve['id_ecole']
		]);
	$resultat=$prepare->fetch();
	$id=$resultat['id'];
	$prepare->closeCursor();
	
	return $id;
}


function updateImage($id, $photo)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE eleve SET photo=:photo WHERE id=?');
	$prepare->execute([
			'id'=>$id,
			'photo'=>$photo
		]);
}