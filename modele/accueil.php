<?php
function connexion($login, $passe)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM utilisateur WHERE login=:login AND passe=:passe');
	$prepare->execute([
			'login'=>$login,
			'passe'=>$passe
		]);
	
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	
	if($nombre>0)
		return true;
	else
		return false;
}


function getInformation($login)
{
	global $base;
	$nombre=0;
	
	$user=[];
	
	$prepare=$base->prepare('SELECT u.id, u.id_ecole AS idEcole, u.nom, u.id_region, u.id_prefecture, u.login, u.id_fonction, f.nom AS nom_fonction
		FROM utilisateur AS u INNER JOIN fonction AS f ON f.id=u.id_fonction WHERE u.login=?');
	$prepare->execute([$login]);
	
	if($resultat=$prepare->fetch())
		$user=$resultat;
	
	return $user;
}