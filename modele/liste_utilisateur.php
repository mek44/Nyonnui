<?php
function getListeUtilisateur()
{
	global $base;
	
	$query='SELECT u.id, u.nom, u.login, u.telephone, u.adresse, r.nom AS nom_region, p.nom AS nom_pref, e.nom AS nom_ecole, f.nom AS nom_fonction 
			FROM utilisateur AS u INNER JOIN region AS r ON r.id=u.id_region INNER JOIN prefecture AS p ON p.id=u.id_prefecture 
			LEFT JOIN ecole AS e ON e.id=u.id_ecole INNER JOIN fonction AS f ON f.id=u.id_fonction ORDER BY u.nom';
			
	$requete=$base->query($query);
	$utilisateurs=$requete->fetchAll();
	
	return $utilisateurs;
}


function getFonction()
{
	global $base;
	
	$requete=$base->query('SELECT nom, id FROM fonction ORDER BY id');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}


function getRegion()
{
	global $base;
	
	$requete=$base->query('SELECT nom, id FROM region ORDER BY nom');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}


function getPrefecture($idRegion)
{
	global $base;

	$prepare=$base->prepare('SELECT id, nom FROM prefecture WHERE id_region=? ORDER BY nom');
	$prepare->execute([$idRegion]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}

function getEcole($idPrefecture)
{
	global $base;
	
	$prepare=$base->prepare('SELECT id, nom FROM ecole WHERE id_prefecture=? ORDER BY nom');
	$prepare->execute([$idPrefecture]);
	$resultat=$prepare->fetchAll();
	
	return $resultat;
}


function updateUtilisateur($id, $region, $prefecture, $ecole, $nom, $adresse, $telephone, $login, $fonction)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE utilisateur SET id_region=:id_region, id_prefecture=:id_prefecture, id_ecole=:id_ecole, nom=:nom, 
		adresse=:adresse, telephone=:telephone, login=:login, id_fonction=:id_fonction WHERE id=:id');
	$prepare->execute([
		'id_region'=>$region,
		'id_prefecture'=>$prefecture,
		'id_ecole'=>$ecole,
		'nom'=>$nom,
		'adresse'=>$adresse,
		'telephone'=>$telephone,
		'login'=>$login,
		'id_fonction'=>$fonction,
		'id'=>$id
	]);
}

function updatePasse($id, $passe)
{
	global $base;
	$prepare=$base->prepare('UPDATE utilisateur SET passe=:passe WHERE id=:id');
	$prepare->execute([
		'passe'=>$passe,
		'id'=>$id
	]);
}