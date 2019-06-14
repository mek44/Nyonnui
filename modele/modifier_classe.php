<?php
function getClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}


function getMatiere($idClasse, $idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT id, nom FROM matiere WHERE id_ecole=:id_ecole AND id NOT IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=:id_classe)');
	$prepare->execute([
			'id_ecole'=>$idEcole,
			'id_classe'=>$idClasse
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getMatiereClasse($idClasse)
{
	global $base;
	
	$prepare=$base->prepare('SELECT m.id, m.nom, mc.coefficient FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere WHERE mc.id_classe=?');
	$prepare->execute([$idClasse]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

$suppression=false;
$modification=false;

if(isset($_POST['matiereASupprimer']) && isset($_POST['classeASupprimer']))
{
	$matiere=(int)$_POST['matiereASupprimer'];
	$classeASupprimer=(int)$_POST['classeASupprimer'];
	
	include_once('connexion_base.php');
	$prepare=$base->prepare('DELETE FROM matiere_classe WHERE id_classe=:id_classe AND id_matiere=:id_matiere');
	$prepare->execute([
			'id_classe'=>$classeASupprimer,
			'id_matiere'=>$matiere
		]);
		
	$suppression=true;
	echo 'supprimer';
}


if(isset($_POST['matiereAModifier']) && isset($_POST['classeAModifier']) && isset($_POST['coefficientAModifier']) && 
	preg_match('#^[1-4]$#', $_POST['coefficientAModifier']))
{
	$matiere=(int)$_POST['matiereAModifier'];
	$classeASupprimer=(int)$_POST['classeAModifier'];
	$coefficient=(int)$_POST['coefficientAModifier'];
	
	include_once('connexion_base.php');
	$prepare=$base->prepare('UPDATE matiere_classe SET coefficient=:coefficient WHERE id_classe=:id_classe AND id_matiere=:id_matiere');
	$prepare->execute([
			'coefficient'=>$coefficient,
			'id_classe'=>$classeASupprimer,
			'id_matiere'=>$matiere
		]);
		
	$modification=true;
	echo 'modifier';
}