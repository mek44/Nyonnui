<?php
function getTuteur($telephone)
{
	global $base;
	
	$nombre=0;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM tuteur WHERE telephone=?');
	$prepare->execute([$telephone]);
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	$prepare->closeCursor();
	
	$tuteur=[];
	
	$prepare=$base->prepare('SELECT id, nom, adresse, telephone FROM tuteur WHERE telephone=?');
	$prepare->execute([$telephone]);
	$tuteur=$prepare->fetch();
	$prepare->closeCursor();
	
	$tuteur['nombre']=$nombre;
	
	return $tuteur;
}