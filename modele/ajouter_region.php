<?php
function isRegionExiste($region)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM region WHERE nom=:nom');
	$prepare->execute(['nom'=>$region]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	if($resultat['nombre']<1)
		return false;
	else
		return true;
}


function insertRegion($region)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO region(nom) VALUES(:nom)');
	$prepare->execute([
			'nom'=>$region
		]);
}
