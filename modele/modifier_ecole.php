<?php
function getInformation($id)
{
	global $base;
	
	$prepare=$base->prepare('SELECT e.nom, e.adresse, e.telephone, e.id_prefecture, e.id_cycle, e.id_etablissement, p.id_region FROM ecole AS e 
		INNER JOIN prefecture AS p ON p.id=e.id_prefecture WHERE e.id=?');
	$prepare->execute([$id]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	return $resultat;
}


function isEcoleExiste($ecole, $id)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare('SELECT nom FROM ecole WHERE id=?');
	$prepare->execute([$id]);
	$resultat=$prepare->fetch();
	$nom=$resultat['nom'];
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM ecole WHERE nom=:nom AND nom!=:oldNom');
	$prepare->execute([
			'nom'=>$ecole,
			'oldNom'=>$nom
		]);
	
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	
	if($nombre>0)
		return true;
	else
		false;
}


function updateEcole($id, $idPrefecture, $nom, $adresse, $telephone, $etablissement, $cycle)
{
	global $base;
	
	$prepare=$base->prepare('UPDATE ecole SET id_prefecture=:id_prefecture, nom=:nom, adresse=:adresse, telephone=:telephone, 
		id_etablissement=:id_etablissement, id_cycle=:id_cycle WHERE id=:id');
	$prepare->execute([
			'id_prefecture'=>$idPrefecture,
			'nom'=>$nom,
			'adresse'=>$adresse,
			'telephone'=>$telephone,
			'id_etablissement'=>$etablissement,
			'id_cycle'=>$cycle,
			'id'=>$id
		]);
}


function getRegion()
{
	global $base;
	
	$requete=$base->query('SELECT nom, id FROM region ORDER BY nom');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}

function getEtablissement()
{
	global $base;
	
	$requete=$base->query('SELECT libelle, id FROM etablissement ORDER BY libelle');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}


function getCycle()
{
	global $base;
	
	$requete=$base->query('SELECT libelle, id FROM cycle ORDER BY libelle');
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

if(isset($_GET['region']))
{
	include_once('connexion_base.php');
	$idRegion=(int)$_GET['region'];
	
	$listePrefecture=getPrefecture($idRegion);
	$option='';
	foreach($listePrefecture as $prefecture)
	{
		$option.='<option value="'.$prefecture['id'].'">'.$prefecture['nom'].'</option>';
	}
	
	echo $option;
}