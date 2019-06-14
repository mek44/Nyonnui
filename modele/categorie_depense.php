<?php
function getCategorie($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT id, libelle FROM categorie_depense WHERE id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}
