<?php
function getListeAnnee($idEleve)
{
	global $base;
	
	$prepare=$base->prepare('SELECT DISTINCT annee FROM classe_eleve WHERE id_eleve=? ORDER BY annee DESC');
	$prepare->execute([$idEleve]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getInformation($idEleve, $annee)
{
	global $base;
	$eleve=[];
	$classe=[];
	
	$prepare=$base->prepare('SELECT matricule, nom, prenom FROM eleve WHERE id=?');
	$prepare->execute([$idEleve]);
	if($donnees=$prepare->fetch())
		$eleve=$donnees;
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_eleve AS ce ON c.id=ce.id_classe WHERE ce.id_eleve=:id_eleve AND ce.annee=:annee');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	if($donnees=$prepare->fetch())
		$classe=$donnees;
	$prepare->closeCursor();
	
	$information=['eleve'=>$eleve, 'classe'=>$classe];
	
	return $information;
}

function getBulletinTrimestre($idEleve, $trimestre, $annee)
{
	global $base;
	
	$itemMois=['Septembre', 'Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août'];
	$debut=($trimestre-1)*3;
	if($trimestre!=1)
		$debut++;
	
	$titre=[];
	$niveau=getNiveau($idEleve, $annee);
	$i=0;
	if($niveau>=7){
		$titre[$i++]="N°";
		$titre[$i++]="Matières";
		$titre[$i++]="Coef";
		$titre[$i++]=$itemMois[$debut];
		$titre[$i++]=$itemMois[$debut+1];
		
		if($trimestre!=3)
				$titre[$i++]=$itemMois[$debut+2];

		if($trimestre==1)
			$titre[$i++]=$itemMois[$debut+3];
		$titre[$i++]="Moyenne";
		$titre[$i++]="Observation";
	}else{
		$titre[$i++]="N°";
		$titre[$i++]="Matières";
		$titre[$i++]=$itemMois[$debut];
		$titre[$i++]=$itemMois[$debut+1];

		if($trimestre!=3)
				$titre[$i++]=$itemMois[$debut+2];
		if($trimestre==1)
			$titre[$i++]=$itemMois[$debut+3];
		$titre[$i++]="Moyenne";
		$titre[$i++]="Observation";
	}
	
	$moy=0;
	$coefficientTotal=0;
	$moyenneTotal=0;
	$mois=[];
	if($trimestre==1){
		$mois[0]=9;
		$mois[1]=10;
		$mois[2]=11;
		$mois[3]=12;
	}else if($trimestre==2){
		$mois[0]=1;
		$mois[1]=2;
		$mois[2]=3;
	}else if($trimestre==3){
		$mois[0]=4;
		$mois[1]=5;
	}
	
	/*on initialise la moyenne de chaque matière par mois*/
	$totalMois=[];
	for($i=0; $i<count($mois); $i++)
	{
		$totalMois[$i]=0;
	}
	
	$requete='SELECT m.id, m.nom, mc.coefficient FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere 
		WHERE mc.id_classe=(SELECT id_classe FROM classe_eleve WHERE id_eleve=:id_eleve AND annee=:annee) ORDER BY nom';
	
	$prepare=$base->prepare($requete);
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	foreach($resultat as $matiere)
	{
		$coefficientTotal+=$matiere['coefficient'];
	}

	/*on récupère la note de chaque matière pour chaque mois*/
	$requete='SELECT valeur FROM note WHERE id_eleve=:id_eleve AND mois=:mois AND id_matiere=:id_matiere AND annee=:annee';
	
	$prepare=$base->prepare($requete);
	for($i=0; $i<count($mois); $i++)
	{
		for($j=0; $j<count($resultat); $j++){
			$prepare->execute([
					'id_eleve'=>$idEleve,
					'mois'=>$mois[$i],
					'id_matiere'=>$resultat[$j]['id'],
					'annee'=>$annee
				]);
			
			$note=0;
			$coefficient=1;
			if($donnees=$prepare->fetch())
			{
				$note=$donnees['valeur'];
			}
			$resultat[$j]['note'.($i+1)]=$note;	
			$totalMois[$i]+=$note*$resultat[$j]['coefficient'];
			$moyenneTotal+=$note*$resultat[$j]['coefficient'];
		}
	}
	
	
	for($i=0; $i<count($resultat); $i++){
		
		$moyMatiere=0;
		$nombreMois=3;
		if($trimestre==1)
			$nombreMois=4;
		else if($trimestre==2)
			$nombreMois=3;
		else if($trimestre==3)
			$nombreMois=2;
				
		/*on calcul la moyenne de chaque matière*/
		for($j=1; $j<=$nombreMois; $j++)
		{
			$moyMatiere+=$resultat[$i]['note'.$j];
		}
		
		$moyenne=$moyMatiere/$nombreMois;
		$resultat[$i]['moyenne']=$moyenne;
		$resultat[$i]['observation']=getObservation($niveau, $moyenne);
	}
	
	$nombreMois=3;
	if($trimestre==1)
		$nombreMois=4;
	else if($trimestre==2)
		$nombreMois=3;
	else if($trimestre==3)
		$nombreMois=2;
	
	return ['titre'=>$titre, 'resultat'=>$resultat, 'nombreMois'=>$nombreMois, 'totalMois'=>$totalMois, 'moyenneGenerale'=>$moyenneTotal,
		'coefficientTotal'=>$coefficientTotal, 'niveau'=>$niveau];
}


function getRangTrimestre($idEleve, $annee, $trimestre)
{
	global $base;
	
	$liste=[];
	$coefficientAll=0;
	
	$prepare=$base->prepare('SELECT id_classe FROM classe_eleve WHERE id_eleve=:id_eleve AND annee=:annee');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	$resultat=$prepare->fetch();
	$idClasse=$resultat['id_classe'];
	$prepare->closeCursor();

	$prepare=$base->prepare('SELECT e.id, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
				WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$annee
		]);
	$liste=$prepare->fetchAll();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT SUM(coefficient) AS somme FROM matiere_classe WHERE id_classe=?');
	$prepare->execute([$idClasse]);
	if($donnees=$prepare->fetch())
	{
		$coefficientAll=$donnees['somme'];
	}
		
	$nombreMois=3;
	if($trimestre==1)
		$nombreMois=4;
	else if($trimestre==2)
		$nombreMois=3;
	else if($trimestre==3)
		$nombreMois=2;
	
	$requete='SELECT n.valeur, mc.coefficient FROM note AS n INNER JOIN eleve AS e ON e.id=n.id_eleve INNER JOIN matiere_classe AS mc
			ON mc.id_matiere=n.id_matiere WHERE mc.id_classe=:id_classe AND n.id_eleve=:id_eleve AND n.annee=:annee ';
	if($trimestre==1)
		$requete.="AND (mois=9 OR mois=10 OR mois=11 OR mois=12)";
	else if($trimestre==2)
		$requete.="AND (mois=1 OR mois=2 OR mois=3)";
	else if($trimestre==3)
		$requete.="AND (mois=4 OR mois=5)";
	
	$prepare=$base->prepare($requete);
		
	for($i=0; $i<count($liste); $i++)
	{
		$moyenne=0;
		$prepare->execute([
			'id_classe'=>$idClasse,
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
			
		while($resultat=$prepare->fetch())
		{
			$moyenne+=$resultat['valeur']*$resultat['coefficient'];
		}
		
		$liste[$i]['moyenne']=$moyenne/($coefficientAll*$nombreMois);	
	}
	
	$rang=0;
	comparaison($liste);
	
	for($i=0; $i<count($liste); $i++){
		if($liste[$i]['id']==$idEleve){
			$rang=$i+1;
			break;
		}
	}
	
	return $rang;
}


function getBulletinAnnuel($idEleve, $annee){
	global $base;
	$titre=[];
	$niveau=getNiveau($idEleve, $annee);
	
	if($niveau>=7){
		$titre[0]="N°";
		$titre[1]="Matières";
		$titre[2]="Coef";
		$titre[3]="Trimestre 1";
		$titre[4]="Trimestre 2";
		$titre[5]="Trimestre 3";
		$titre[6]="Moyenne";
		$titre[7]="Observation";
	}else{
		$titre[0]="N°";
		$titre[1]="Matières";
		$titre[2]="Trimestre 1";
		$titre[3]="Trimestre 2";
		$titre[4]="Trimestre 3";
		$titre[5]="Moyenne";
		$titre[6]="Observation";
	}
	
	$resultat=[];
	$moyTrimestre=[];
	$coefficientAll=0;
	$moyenneAll=0;
	
	$requete='SELECT m.id, m.nom, mc.coefficient FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere 
			WHERE mc.id_classe=(SELECT id_classe FROM classe_eleve WHERE id_eleve=:id_eleve AND annee=:annee) ORDER BY nom';
	
	$prepare=$base->prepare($requete);
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	foreach($resultat as $matiere){
		$coefficientAll+=$matiere['coefficient'];
	}
	
	for($j=1; $j<4; $j++){
		$requete='SELECT n.valeur, mc.coefficient FROM note AS n INNER JOIN eleve AS e ON e.id=n.id_eleve 
				INNER JOIN matiere_classe AS mc ON mc.id_matiere=n.id_matiere WHERE mc.id_classe=(SELECT id_classe FROM classe_eleve WHERE id_eleve=:ce_id_eleve AND annee=:ce_annee)
				AND n.id_eleve=:n_id_eleve AND n.id_matiere=:id_matiere AND n.annee=:n_annee ';
		if($j==1)
			$requete.="AND (mois=9 OR mois=10 OR mois=11 OR mois=12)";
		else if($j==2)
			$requete.="AND (mois=1 OR mois=2 OR mois=3)";
		else
			$requete.="AND (mois=4 OR mois=5)";	
		
		$moyTrim=0;
		$prepare=$base->prepare($requete);
		
		for($i=0; $i<count($resultat); $i++){
			$prepare->execute([
					'ce_id_eleve'=>$idEleve,
					'ce_annee'=>$annee,
					'n_id_eleve'=>$idEleve,
					'id_matiere'=>$resultat[$i]['id'],
					'n_annee'=>$annee
				]);
			
			$note=0;

			while($donnees=$prepare->fetch()){
				$note+=$donnees['valeur'];
				$moyTrim+=$donnees['valeur']*$donnees['coefficient'];
			}
			
			$nombreMois=3;
			
			if($j==1)
				$nombreMois=4;
			else if($j==2)
				$nombreMois=3;
			else if($j==3)
				$nombreMois=2;
			
			$resultat[$i]['trime'.$j]=$note/$nombreMois;
			
			$moyTrimestre[$j-1]=$moyTrim/($coefficientAll*$nombreMois);
		}
	}
	
	for($i=0; $i<count($resultat); $i++){
		
		$trim1=$resultat[$i]['trime1'];
		$trim2=$resultat[$i]['trime2'];
		$trim3=$resultat[$i]['trime3'];
		
		$moyenne=($trim1+$trim2+$trim3)/3;
		$resultat[$i]['moyenne']=$moyenne;
		$resultat[$i]['observation']=getObservation($niveau, $moyenne);
	}
	
	foreach($moyTrimestre as $moy)
	{
		$moyenneAll+=$moy;
	}
	
	$moyenneAll/=3;
	
	
	return ['resultat'=>$resultat, 'moyenneGenerale'=>$moyenneAll, 'titre'=>$titre, 'niveau'=>$niveau, 'coefficientTotal'=>$coefficientAll,
		'moyenneTrimestre'=>$moyTrimestre];
}
	



function getRangAnnuel($idEleve, $annee)
{
	global $base;
	$liste=[];
	$coefficientAll=0;
	
	$prepare=$base->prepare('SELECT id_classe FROM classe_eleve WHERE id_eleve=:id_eleve AND annee=:annee');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	$resultat=$prepare->fetch();
	$idClasse=$resultat['id_classe'];
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT e.id, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
			WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$annee
		]);
	$liste=$prepare->fetchAll();
	$prepare->closeCursor();
		
	$prepare=$base->prepare('SELECT SUM(coefficient) AS somme FROM matiere_classe WHERE id_classe=?');
	$prepare->execute([$idClasse]);
	
	if($donnees=$prepare->fetch()){
		$coefficientAll=$donnees['somme'];
	}
	$prepare->closeCursor();
	
	for($i=1; $i<4; $i++){
		$requete="SELECT n.valeur, mc.coefficient FROM note AS n INNER JOIN eleve AS e ON e.id=n.id_eleve 
				INNER JOIN matiere_classe AS mc ON mc.id_matiere=n.id_matiere WHERE n.annee=:annee AND n.id_eleve=:id_eleve ";
		
		if($i==1)
			$requete.="AND (mois=9 OR mois=10 OR mois=11 OR mois=12)";
		else if($i==2)
			$requete.="AND (mois=1 OR mois=2 OR mois=3)";
		else if($i==3)
			$requete.="AND (mois=4 OR mois=5)";
		
		$prepare=$base->prepare($requete);
		
		for($j=0; $j<count($liste); $j++){
			$moyenne=0;
			$prepare->execute([
					'annee'=>$annee,
					'id_eleve'=>$idEleve
				]);
			
			while($donnees=$prepare->fetch()){
				$moyenne+=$donnees['valeur']*$donnees['coefficient'];
			}
			
			if($i==1)
				$liste[$j]['trime1']=$moyenne/($coefficientAll*4);
			else if($i==2)
				$liste[$j]['trime2']=$moyenne/($coefficientAll*3);
			else if($i==3)
				$liste[$j]['trime3']=$moyenne/($coefficientAll*2);
		}
	}
	
	
	for($j=0; $j<count($liste); $j++){
		$moy=$liste[$j]['trime1']+$liste[$j]['trime2']+$liste[$j]['trime3'];
		$liste[$j]['moyenne']=$moy/3;
	}
	
	comparaison($liste);
	$rang=0;
	
	for($i=0; $i<count($liste); $i++){
		if($liste[$i]['id']==$idEleve){
			$rang=$i+1;
			break;
		}
	}
	
	return $rang;	
}

function getObservation($niveau, $moyenne)
{
	$observation='';
	
	if($niveau<7)
	{
		if($moyenne<5)
			$observation="Mediocre";
		else if($moyenne<6)
			$observation="Passable";
		else if($moyenne<7)
			$observation="Assez Bien";
		else if($moyenne<9)
			$observation="Bien";
		else if($moyenne<=10)
			$observation="Très Bien";
	}
	else
	{
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
			$observation="Très bien";
	}
	
	return $observation;
}

function getNiveau($idEleve, $annee)
{
	global $base;
	$niveau=0;
	
	$prepare=$base->prepare('SELECT c.niveau FROM classe AS c INNER JOIN classe_eleve AS ce ON c.id=ce.id_classe WHERE ce.id_eleve=:id_eleve AND ce.annee=:annee');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'annee'=>$annee
		]);
	if($donnees=$prepare->fetch())
		$niveau=$donnees['niveau'];
	$prepare->closeCursor();
	
	return $niveau;
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


if(isset($_GET['annee']) && isset($_GET['trimestre']))
{
	session_start();
	include_once('connexion_base.php');
	include_once('../fonction.php');
	
	$annee=$_GET['annee'];
	$trimestre=(int)$_GET['trimestre'];
	
	$information=getInformation($_SESSION['idEleve'], $annee);
	$eleve=$information['eleve'];
	$classe=$information['classe'];
	if($trimestre!=4)
	{
		$bulletin=getBulletinTrimestre($_SESSION['idEleve'], $trimestre, $annee);
		$rang=getRangTrimestre($_SESSION['idEleve'], $annee, $trimestre);
		$titre=$bulletin['titre'];
		$resultat=$bulletin['resultat'];
		$nombreMois=$bulletin['nombreMois'];
		$totalMois=$bulletin['totalMois'];
		$coefficientTotal=$bulletin['coefficientTotal'];
		$moyenneGenerale=$bulletin['moyenneGenerale']/($coefficientTotal*$nombreMois);
		$niveau=$bulletin['niveau'];
	}
	else
	{
		$bulletin=getBulletinAnnuel($_SESSION['idEleve'], $annee);
		$rang=getRangAnnuel($_SESSION['idEleve'], $annee);
		$titre=$bulletin['titre'];
		$resultat=$bulletin['resultat'];
		$coefficientTotal=$bulletin['coefficientTotal'];
		$moyenneGenerale=$bulletin['moyenneGenerale'];
		$moyenneTrimestre=$bulletin['moyenneTrimestre'];
		$niveau=$bulletin['niveau'];
	}
	
	$observation=getObservation($classe['niveau'], $moyenneGenerale);
	
	$libelleClasse=$classe['niveau'].' ';
/*	if($classe['niveau']!=13)
	{
		$libelleClasse=$classe['niveau'];
		if($classe['niveau']==1)
			$libelleClasse.='ère ';
		else
			$libelleClasse.='ème ';
	}
	else
		$libelleClasse='Terminal';
*/	
	if($classe['niveau']>10)
		$libelleClasse.=$classe['option_lycee'];

	if($classe['niveau']!=13)
		$libelleClasse.='année';
	
	$note='<table class="table table-bordered table-striped table-condensed">
				<tr>';
	foreach($titre as $element)
	{
		$note.='<th>'.$element.'</th>';
	}
	$note.='</tr>';
	
	if($trimestre!=4)
	{
		$i=1;
		foreach($resultat as $matiere)
		{
			$note.='<tr class="eleve">
				<td>'.$i.'</td>
				<td>'.$matiere['nom'].'</td>';
				
			if($niveau>=7)
			{
				$note.='<td>'.$matiere['coefficient'].'</td>';
			}
				
			for($j=1; $j<=$nombreMois; $j++)
			{
				$note.='<td>'.parseReel($matiere['note'.$j]).'</td>';
			}							
			$note.='<td>'.parseReel($matiere['moyenne']).'</td>
				<td>'.$matiere['observation'].'</td>
			</tr>';
			$i++;
		}
		
		$note.='<tr>
			<td></td>
			<td></td>';
			
			if($niveau>=7)
			{
				$note.='<td></td>';
			}
			
			foreach($totalMois as $element)
			{
				$note.='<td>'.parseReel($element/$coefficientTotal).'</td>';
			}
			
			$note.='<td>'.parseReel($moyenneGenerale).'</td>
				<td>'.$observation.'</td>
			</tr>
		</table>';
	}
	else
	{
		$i=1;
		foreach($resultat as $matiere)
		{
			$note.='<tr class="eleve">
				<td>'.$i.'</td>
				<td>'.$matiere['nom'].'</td>';
				
			if($niveau>=7)
			{
				$note.='<td>'.$matiere['coefficient'].'</td>';
			}
			$note.='<td>'.parseReel($matiere['trime1']).'</td>';
			$note.='<td>'.parseReel($matiere['trime2']).'</td>';
			$note.='<td>'.parseReel($matiere['trime3']).'</td>';
				
										
			$note.='<td>'.parseReel($matiere['moyenne']).'</td>
				<td>'.$matiere['observation'].'</td>
			</tr>';
			$i++;
		}
		
		$note.='<tr>
			<td></td>
			<td></td>';
			
			if($niveau>=7)
			{
				$note.='<td></td>';
			}
			
			foreach($moyenneTrimestre as $moy)
			{
				$note.='<td>'.parseReel($moy).'</td>';
			}
			
			$note.='<td>'.parseReel($moyenneGenerale).'</td>
				<td>'.$observation.'</td>
			</tr>';
		$note.='</table>';
	}
	

	$title='Bulletin de note ';
	if($trimestre==4)
		$title.='annuel';
	else
		$title.=$libelleClasse.' Trimestre '.$trimestre;

	$reponse=['note'=>$note, 'title'=>$title, 'rang'=>$rang, 'moyenne'=>parseReel($moyenneGenerale)];
	echo json_encode($reponse);
}