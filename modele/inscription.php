<?php
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


function insertTuteur(array $tuteur)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO tuteur(nom, adresse, telephone, passe, id_ecole) VALUES(:nom, :adresse, :telephone, :passe, :idEcole)');
	$prepare->execute([
		'nom'=>$tuteur['nomTuteur'],
		'adresse'=>$tuteur['adresse'],
		'telephone'=>$tuteur['telephone'],
		'passe'=>$tuteur['passe'],
                'idEcole'=>$tuteur['idEcole']
		]);
	
	$requete=$base->query('SELECT LAST_INSERT_ID() AS id');
	$resultat=$requete->fetch();
	$requete->closeCursor();
	return $resultat['id'];
}


function tuteurExiste($id)
{
	global $base;
	
	$nombre=0;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM tuteur WHERE id=?');
	$prepare->execute([$id]);
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	$prepare->closeCursor();
	
	if($nombre>0)
		return true;
	else
		return false;
}

function insertEleve(array $eleve, $cours, $annee)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO eleve(id_ecole, matricule, nom, prenom, sexe, date_naissance, lieu_naissance, pere, mere, date_inscription, id_tuteur, 
		pv_dernier_examen, rang_dernier_examen, ecole_origine, session_dernier_examen, passe) VALUES(:id_ecole, :matricule, :nom, :prenom, :sexe, :date_naissance, 
		:lieu_naissance, :pere, :mere, :date_inscription, :id_tuteur, :pv_dernier_examen, :rang_dernier_examen, :ecole_origine, :session_dernier_examen, :passe)');
	$prepare->execute([
		'id_ecole'=>$eleve['id_ecole'],
		'matricule'=>$eleve['matricule'],
		'nom'=>$eleve['nom'],
		'prenom'=>$eleve['prenom'],
		'sexe'=>$eleve['sexe'],
		'date_naissance'=>$eleve['date_naissance'],
		'lieu_naissance'=>$eleve['lieu_naissance'],
		'pere'=>$eleve['pere'],
		'mere'=>$eleve['mere'],
		'date_inscription'=>$eleve['date_inscription'],
		'id_tuteur'=>$eleve['id_tuteur'],
		'pv_dernier_examen'=>$eleve['pv_dernier_examen'],
		'rang_dernier_examen'=>$eleve['rang_dernier_examen'],
		'ecole_origine'=>$eleve['ecole_origine'],
		'session_dernier_examen'=>$eleve['session_dernier_examen'],
		'passe'=>$eleve['passe']
		]);
	
	$requete=$base->query('SELECT LAST_INSERT_ID() AS id');
	$resultat=$requete->fetch();
	$id=$resultat['id'];
	$requete->closeCursor();
	
	$prepare=$base->prepare('INSERT INTO classe_eleve(id_classe, id_eleve, date_inscription, annee) VALUES(:id_classe, :id_eleve, :date_inscription, :annee)');
	$prepare->execute([
		'id_classe'=>$cours, 
		'id_eleve'=>$id,
		'date_inscription'=>$eleve['date_inscription'],
		'annee'=>$annee
		]);
	
	return $id;
}


function updateImage($id, $photo)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE eleve SET photo=:photo WHERE id=:id');
	$prepare->execute([
		'id'=>$id,
		'photo'=>$photo
		]);
}


function getClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

