<?php
function isLoginExiste($login)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM utilisateur WHERE login=?');
	$prepare->execute([$login]);
	
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	
	if($nombre>0)
		return true;
	else
		false;
}

function getFonction()
{
	global $base;
	
	$requete=$base->query('SELECT nom, id FROM fonction ORDER BY id');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}


function insertUtilisateur($region, $prefecture, $ecole, $nom, $adresse, $telephone, $login, $passe, $fonction)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO utilisateur(id_region, id_prefecture, id_ecole, nom, adresse, telephone, login, passe, id_fonction) 
		VALUES(:id_region, :id_prefecture, :id_ecole, :nom, :adresse, :telephone, :login, :passe, :fonction)');
	$prepare->execute([
			'id_region'=>$region,
			'id_prefecture'=>$prefecture,
			'id_ecole'=>$ecole,
			'nom'=>$nom,
			'adresse'=>$adresse,
			'telephone'=>$telephone,
			'login'=>$login,
			'passe'=>$passe,
			'fonction'=>$fonction
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


if(isset($_GET['region']))
{
	include_once('connexion_base.php');
	$idRegion=(int)$_GET['region'];
	
	$listePrefecture=getPrefecture($idRegion);
	$optionPrefecture='';
	foreach($listePrefecture as $prefecture)
	{
		$optionPrefecture.='<option value="'.$prefecture['id'].'">'.$prefecture['nom'].'</option>';
	}
	
	$listeEcole=[];
	if(count($listePrefecture)>0)
		$listeEcole=getEcole($listePrefecture[0]['id']);
	
	$optionEcole='';
	foreach($listeEcole as $ecole)
	{
		$optionEcole.='<option value="'.$ecole['id'].'">'.$ecole['nom'].'</option>';
	}
	
	echo json_encode(['prefecture'=>$optionPrefecture, 'ecole'=>$optionEcole]);
}


if(isset($_GET['prefecture']))
{
	include_once('connexion_base.php');
	$idPrefecture=(int)$_GET['prefecture'];
	
	$listeEcole=getEcole($idPrefecture);
	
	$optionEcole='';
	foreach($listeEcole as $ecole)
	{
		$optionEcole.='<option value="'.$ecole['id'].'">'.$ecole['nom'].'</option>';
	}
	
	echo $optionEcole;
}