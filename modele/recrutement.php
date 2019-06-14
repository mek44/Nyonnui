<?php
function isMatriculeExist($matricule)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM personnel WHERE id_ecole=:id_ecole AND matricule=:matricule');
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


function insertPersonnel(array $personnel)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO personnel(id_ecole, matricule, nom, prenom, sexe, date_naissance, lieu_naissance, quartier, telephone,
		fonction, date_engagement, salaire_base, taux_horaire, code, passe) VALUES(:id_ecole, :matricule, :nom, :prenom, :sexe, :date_naissance, 
		:lieu_naissance, :quartier, :telephone, :fonction, :date_engagement, :salaire, :taux_horaire, :code, :passe)');
	$prepare->execute([
		'id_ecole'=>$personnel['id_ecole'],
		'matricule'=>$personnel['matricule'],
		'nom'=>$personnel['nom'],
		'prenom'=>$personnel['prenom'],
		'sexe'=>$personnel['sexe'],
		'date_naissance'=>$personnel['date_naissance'],
		'lieu_naissance'=>$personnel['lieu_naissance'],
		'quartier'=>$personnel['adresse'],
		'telephone'=>$personnel['telephone'],
		'fonction'=>$personnel['fonction'],
		'date_engagement'=>$personnel['date_engagement'],
		'salaire'=>$personnel['salaire'],
		'taux_horaire'=>$personnel['taux'],
		'code'=>$personnel['code'],
		'passe'=>$personnel['passe']
		]);
	
	$requete=$base->query('SELECT LAST_INSERT_ID() AS id');
	$resultat=$requete->fetch();
	$id=$resultat['id'];
	$requete->closeCursor();
	
	return $id;
}


function updateImage($id, $photo)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE personnel SET photo=:photo WHERE id=:id');
	$prepare->execute([
		'id'=>$id,
		'photo'=>$photo
		]);
}
