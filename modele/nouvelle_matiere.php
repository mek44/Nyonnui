<?php
function isMatiereExiste($matiere)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM matiere WHERE id_ecole=:id_ecole AND nom=:nom');
	$prepare->execute(array(
		'id_ecole'=>$_SESSION['user']['idEcole'],
		'nom'=>$matiere));
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	if($resultat['nombre']<1)
		return false;
	else
		return true;
}


function insertMatiere($matiere)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO matiere(id_ecole, nom) VALUES(:id_ecole, :nom)');
	$prepare->execute([
			'id_ecole'=>$_SESSION['user']['idEcole'],
			'nom'=>$matiere
		]);
}
