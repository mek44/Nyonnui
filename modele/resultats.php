<?php
function getListeClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}


function getResultatTrimestre($idClasse, $trimestre)
{
	global $base;
	$liste=[];
	$coefficientAll=0;
	
	$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$_SESSION['annee']
		]);
	$liste=$prepare->fetchAll();
	$prepare->closeCursor();

		
	$prepare=$base->prepare('SELECT SUM(coefficient) AS somme FROM matiere_classe WHERE id_classe=?'); 
	$prepare->execute([$idClasse]);
	$resultat=$prepare->fetch();
	$coefficientAll=$resultat['somme'];
	$prepare->closeCursor();
		
	$requete='SELECT n.valeur, mc.coefficient FROM note AS n INNER JOIN eleve AS e ON e.id=n.id_eleve INNER JOIN matiere_classe AS mc 
				ON mc.id_matiere=n.id_matiere WHERE mc.id_classe=:id_classe AND n.id_eleve=:id_eleve AND n.annee=:annee ';
	if($trimestre==1)
		$requete.='AND (mois=9 OR mois=10 OR mois=11 OR mois=12)';
	else if($trimestre==2)
		$requete.='AND (mois=1 OR mois=2 OR mois=3)';
	else if($trimestre==3)
		$requete.='AND (mois=4 OR mois=5)';
		
	$prepare=$base->prepare($requete);
		
	$nombreMois=3;
	
	if($trimestre==1)
		$nombreMois=4;
	else if($trimestre==2)
		$nombreMois=3;
	else if($trimestre==3)
		$nombreMois=2;
	
	for($i=0; $i<count($liste); $i++){
		$moyenne=0;
		$prepare->execute([
				'id_classe'=>$idClasse,
				'id_eleve'=>$liste[$i]['id'],
				'annee'=>$_SESSION['annee']
			]);
		
		while($resultat=$prepare->fetch()){
			$moyenne+=$resultat['valeur']*$resultat['coefficient'];
		}
		
		$liste[$i]['moyenne']=$moyenne/($coefficientAll*$nombreMois);	
	}
	$prepare->closeCursor();
	comparaison($liste);
	
	for($i=0; $i<count($liste); $i++){
		$observation='observation';
		$moyenne=$liste[$i]['moyenne'];
		if($moyenne<=7)
			$observation="Très faible";
		else if($moyenne<=9)
			$observation="faible";
		else if($moyenne<=11)
			$observation="passable";
		else if($moyenne<=13)
			$observation="Assez bien";
		else if($moyenne<=15)
			$observation="Bien";
		else if($moyenne>15)
			$observation="Très Bien";
		
		$liste[$i]['observation']=$observation;
		$liste[$i]['rang']=$i+1;
	}
	
	return $liste;	
}

function getResultatAnnuel($classe)
{
	global $base;
	
	$liste=[];
	$coefficientAll=0;
		
		
	$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
					WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$classe,
			'annee'=>$_SESSION['annee']
		]);
			
	$liste=$prepare->fetchAll();		
	$prepare->closeCursor();
			
	$prepare=$base->prepare('SELECT SUM(coefficient) AS somme FROM matiere_classe WHERE id_classe=?'); 
	$prepare->execute([$classe]);
	$resultat=$prepare->fetch();
	$coefficientAll=$resultat['somme'];
	$prepare->closeCursor();
			
	for($i=1; $i<4; $i++){
		$requete='SELECT n.valeur, mc.coefficient FROM note AS n INNER JOIN eleve AS e ON e.id=n.id_eleve INNER JOIN matiere_classe AS mc 
				ON mc.id_matiere=n.id_matiere WHERE mc.id_classe=:id_classe AND n.id_eleve=:id_eleve AND n.annee=:annee ';
		if($i==1) 
			$requete.='AND (mois=9 OR mois=10 OR mois=11 OR mois=12)';
		else if($i==2)
			$requete.='AND (mois=1 OR mois=2 OR mois=3)';
		else if($i==3)
			$requete.='AND (mois=4 OR mois=5)';
		
		$prepare=$base->prepare($requete);
		
		for($j=0; $j<count($liste); $j++){
			$moyenne=0;
			$prepare->execute([
				'id_classe'=>$classe,
				'id_eleve'=>$liste[$j]['id'],
				'annee'=>$_SESSION['annee']
			]);
			
			while($resultat=$prepare->fetch()){
				$moyenne+=$resultat['valeur']*$resultat['coefficient'];
			}
			
			if($i==1)
				$liste[$j]['trime1']=$moyenne/($coefficientAll*4);
			else if($i==2)
				$liste[$j]['trime2']=$moyenne/($coefficientAll*3);
			else if($i==3)
				$liste[$j]['trime3']=$moyenne/($coefficientAll*2);
		}
		$prepare->closeCursor();
	}
			
		
	for($j=0; $j<count($liste); $j++){
		$moyenne=$liste[$j]['trime1']+$liste[$j]['trime2']+$liste[$j]['trime3'];
		$liste[$j]['moyenne']=$moyenne/3;
	}
		
	comparaison($liste);
		
	for($i=0; $i<count($liste); $i++){
		$observation='observation';
		$moyenne=$liste[$i]['moyenne'];
		if($moyenne<=7)
			$observation="Très faible";
		else if($moyenne<=9)
			$observation="faible";
		else if($moyenne<=11)
			$observation="passable";
		else if($moyenne<=13)
			$observation="Assez bien";
		else if($moyenne<=15)
			$observation="Bien";
		else if($moyenne>15)
			$observation="Très Bien";
		
		$liste[$i]['observation']=$observation;
		$liste[$i]['rang']=$i+1;
	}
	
	return $liste;	
}

function comparaison(array &$liste)
{
	$trie=true;
	
	do
	{
		$trie=true;
		
		for($i=0; $i<count($liste)-1; $i++)
		{
			if($liste[$i]['moyenne']<$liste[$i+1]['moyenne'])
			{
				$inter=$liste[$i];
				$liste[$i]=$liste[$i+1];
				$liste[$i+1]=$inter;
				$trie=false;
			}
		}
	}while(!$trie);
}


if(isset($_GET['classe']) && isset($_GET['trimestre']))
{
	session_start();
	include_once('connexion_base.php');
	include_once('../fonction.php');
	
	$classe=(int)$_GET['classe'];
	$trimestre=(int)$_GET['trimestre'];
	
	if($trimestre<4)
		$resultat=getResultatTrimestre($classe, $trimestre);
	else
		$resultat=getResultatAnnuel($classe);
	
	$table='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Matricule</th>
					<th>Nom</th>
					<th>Prénom</th>';
					
	if($trimestre==4)
	{
		$table.='<th>Trimestre 1</th>
				<th>Trimestre 2</th>
				<th>Trimestre 3</th>';
	}
	$table.='<th>Rang</th>
			<th>Moyenne</th>
			<th>Observation</th>
			<th></th>
		</tr>';
	
	foreach($resultat as $eleve)
	{
		$table.='<tr class="eleve" id="'.$eleve['matricule'].'">
			<td>'.$eleve['matricule'].'</td>
			<td>'.$eleve['nom'].'</td>
			<td>'.$eleve['prenom'].'</td>';
			
		if($trimestre==4)
		{
			$table.='<td>'.parseReel($eleve['trime1']).'</td>
			<td>'.parseReel($eleve['trime2']).'</td>
			<td>'.parseReel($eleve['trime3']).'</td>';
		}
			
		$table.='<td>'.$eleve['rang'].'</td>
			<td>'.parseReel($eleve['moyenne']).'</td>
			<td>'.$eleve['observation'].'</td>
			<td><a href="bulletin.php?id='.$eleve['id'].'">bulletin</a></td>
		</tr>';
	}
	
	$table.='</table>';
	
	echo $table;
}