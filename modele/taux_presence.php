<?php
function getTauxPresence($idEcole, $listeMois, $moisActuel, $annee)
{
	global $base;
	
	$listeTaux=[];
	//$prepareEffectif=$base->prepare('SELECT COUNT(id_eleve) AS effectif FROM classe_eleve WHERE annee=:annee 
		//AND id_eleve IN (SELECT id FROM eleve WHERE id_ecole=:id_ecole)');
		
	$preparePresencePossible=$base->prepare('SELECT COUNT(*) AS presence_possible FROM controle WHERE annee=:annee AND MONTH(date)=:mois 
		AND id_eleve IN (SELECT id FROM eleve WHERE id_ecole=:id_ecole)');
		
	
	$preparePresenceEffective=$base->prepare('SELECT COUNT(*) AS presence_effective FROM controle WHERE annee=:annee AND MONTH(date)=:mois AND present=1 
		AND id_eleve IN (SELECT id FROM eleve WHERE id_ecole=:id_ecole)');
	foreach($listeMois as $nom=>$valeur)
	{
		$taux['mois']=$nom;
		
		$preparePresencePossible->execute([
				'annee'=>$annee,
				'mois'=>$valeur,
				'id_ecole'=>$idEcole
			]);
		$presencePossible=0;
		if($donnees=$preparePresencePossible->fetch())
			$presencePossible=$donnees['presence_possible'];
		
		$presenceEffective=0;
		$preparePresenceEffective->execute([
				'annee'=>$annee,
				'mois'=>$valeur,
				'id_ecole'=>$idEcole
			]);
		$nombre=0;
		if($donnees=$preparePresenceEffective->fetch())
			$presenceEffective=$donnees['presence_effective'];
		
		$taux['taux_presence']=$presencePossible==0?0:($presenceEffective*100)/$presencePossible;
		
		array_push($listeTaux, $taux);
		
		if($valeur==$moisActuel)
			break;
	}
	
	return $listeTaux;
}

function getNomEcole($idEcole)
{
	global $base;
	
	$nom='';
	
	$prepare=$base->prepare('SELECT nom FROM ecole WHERE id=?');
	$prepare->execute([$idEcole]);
	if($donnees=$prepare->fetch())
		$nom=$donnees['nom'];
	$prepare->closeCursor();
	
	return $nom;
}