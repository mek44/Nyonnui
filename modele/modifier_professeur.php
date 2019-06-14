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


function updatePersonnel(array $personnel)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE personnel SET nom=:nom, prenom=:prenom, sexe=:sexe, date_naissance=:date_naissance, lieu_naissance=:lieu_naissance,
		quartier=:adresse, telephone=:telephone, fonction=:fonction, date_engagement=:date_engagement, 
		salaire_base=:salaire, taux_horaire=:taux_horaire WHERE id_ecole=:id_ecole AND matricule=:matricule');
	$prepare->execute([
			'nom'=>$personnel['nom'],
			'prenom'=>$personnel['prenom'],
			'sexe'=>$personnel['sexe'],
			'date_naissance'=>$personnel['date_naissance'],
			'lieu_naissance'=>$personnel['lieu_naissance'],
			'adresse'=>$personnel['adresse'],
			'telephone'=>$personnel['telephone'],
			'fonction'=>$personnel['fonction'],
			'date_engagement'=>$personnel['date_engagement'],
			'salaire'=>$personnel['salaire'],
			'taux_horaire'=>$personnel['taux'],
			'id_ecole'=>$personnel['id_ecole'],
			'matricule'=>$personnel['matricule']
		]);
	
	$prepare=$base->prepare('SELECT id FROM personnel WHERE id_ecole=:id_ecole AND matricule=:matricule');
	$prepare->execute([
			'id_ecole'=>$personnel['id_ecole'],
			'matricule'=>$personnel['matricule'],
		]);
	$resultat=$prepare->fetch();
	$id=$resultat['id'];
	$prepare->closeCursor();
	
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
