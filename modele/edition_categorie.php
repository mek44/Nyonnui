<?php
function isCategorieExiste($libelle, $idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM categorie_depense WHERE libelle=:libelle AND id_ecole=:id_ecole');
	$prepare->execute([
			'libelle'=>$libelle,
			'id_ecole'=>$idEcole
		]);
		
	$resultat=$prepare->fetch();
	$nombre=$resultat['nombre'];
	$prepare->closeCursor();
	
	if($nombre>0)
		return true;
	else
		return false;
}

function ajouterCategorie($libelle, $idEcole)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO categorie_depense(libelle, id_ecole) VALUES(:libelle, :id_ecole)');
	$prepare->execute([
			'libelle'=>$libelle,
			'id_ecole'=>$idEcole
		]);
}


function editerCategorie($libelle, $idEcole, $id)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE categorie_depense SET libelle=:libelle WHERE id_ecole=:id_ecole AND id=:id');
	$prepare->execute([
			'libelle'=>$libelle,
			'id_ecole'=>$_SESSION['user']['idEcole'],
			'id'=>$id
		]);
}