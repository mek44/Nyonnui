<?php
function isPrefectureExiste($nom)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM prefecture WHERE nom=:nom');
	$prepare->execute(['nom'=>$nom]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	if($resultat['nombre']<1)
		return false;
	else
		return true;
}


function insertPrefecture($nom, $region)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO prefecture(nom, id_region) VALUES(:nom, :id_region)');
	$prepare->execute([
			'nom'=>$nom,
			'id_region'=>$region
		]);
}


function getRegion()
{
	global $base;
	
	$prepare=$base->query('SELECT id, nom FROM region ORDER BY nom');
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}
