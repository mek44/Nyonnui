<?php
function getStatistique($idEcole, $annee, $date)
{
	global $base;
	
	//recuperation de la classe et l'effectif total
	$prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS effectif, c.id, c.niveau, c.intitule, c.option_lycee FROM classe_eleve AS ce 
		INNER JOIN classe AS c ON c.id=ce.id_classe WHERE ce.annee=:annee AND c.id_ecole=:id_ecole GROUP BY ce.id_classe');
	$prepare->execute([
			'annee'=>$annee,
			'id_ecole'=>$idEcole
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	//recuperation de l'effectif en fontion du sexe
	$prepare=$base->prepare("SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce 
		INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN eleve AS e ON e.id=ce.id_eleve 
		WHERE ce.annee=:annee AND c.id_ecole=:id_ecole_classe AND e.id_ecole=:id_ecole_eleve AND e.sexe=:sexe AND ce.id_classe=:id_classe");
		
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'annee'=>$annee,
				'id_ecole_classe'=>$idEcole,
				'id_ecole_eleve'=>$idEcole,
				'sexe'=>'F',
				'id_classe'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['fille']=$donnee['nombre'];
		}
		
		$prepare->execute([
				'annee'=>$annee,
				'id_ecole_classe'=>$idEcole,
				'id_ecole_eleve'=>$idEcole,
				'sexe'=>'M',
				'id_classe'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['garcon']=$donnee['nombre'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation du nombre d'absent
	$prepare=$base->prepare('SELECT COUNT(id_eleve) AS absent FROM controle
		WHERE present=0 AND date=:date AND id_eleve IN (SELECT id_eleve FROM classe_eleve WHERE id_classe=:id_classe AND annee=:annee)');
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'date'=>$date,
				'annee'=>$annee,
				'id_classe'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['absent']=$donnee['absent'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation du nombre de fille absent 
	$prepare=$base->prepare("SELECT COUNT(id_eleve) AS absent FROM controle 
		WHERE present=0 AND date=:date AND id_eleve IN (SELECT ce.id_eleve FROM classe_eleve AS ce INNER JOIN eleve AS e ON e.id=ce.id_eleve
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee AND e.sexe='F')");
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'date'=>$date,
				'annee'=>$annee,
				'id_classe'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['fille_absent']=$donnee['absent'];
		}
	}
	$prepare->closeCursor();
	
	return $resultat;
}


function getClasseEnseignant($user)
{
    global $base;

    $resultat=[];
    
    $requete='';
    if($user['niveau']==='Primaire'){
        $requete='SELECT c.id FROM classe AS c INNER JOIN classe_enseignant AS ce ON c.id=ce.id_classe WHERE ce.id_enseignant=?';
    }else{
        $requete='SELECT DISTINCT c.id FROM classe AS c INNER JOIN classe_matiere_enseignant AS cm ON c.id=cm.id_classe WHERE cm.id_enseignant=?';
    }
        
    $prepare=$base->prepare($requete);
    $prepare->execute([$user['id']]);
    while(($donnees=$prepare->fetch())){
        array_push($resultat, $donnees['id']);
    }
    $prepare->closeCursor();
    return $resultat;
}


function getEcole($idEcole)
{
	global $base;
	
	$nom='';
	
	$prepare=$base->prepare('SELECT nom FROM ecole WHERE id=?');
	$prepare->execute([$idEcole]);
	if($resultat=$prepare->fetch())
		$nom=$resultat['nom'];
	
	$prepare->closeCursor();
	
	return $nom;
}


if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['id_ecole']))
{
	$jour=(int)$_GET['jour'];
	$mois=(int)$_GET['mois'];
	$annee=(int)$_GET['annee'];
	$idEcole=(int)$_GET['id_ecole'];
	
	if(checkdate($mois, $jour, $annee))
	{
		session_start();
		include_once('connexion_base.php');
		
		$date=$annee.'-'.$mois.'-'.$jour;
		
		if(isset($_SESSION['user']) && isset($_SESSION['annee']))
		{
			$statistique=getStatistique($idEcole, $_SESSION['annee'], $date);
			$code='';
			
			foreach($statistique as $classe)
			{
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
					$libelle.=$classe['option_lycee'];
			
				$libelle.=$classe['intitule'];
				
				$code.='<div class="col-lg-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">'.$libelle.'</h1>
						</div>
						
						<div class="panel-body">
							<ul class="list-group">
								<li class="list-group-item">Effectif: <span class="badge succes">'.$classe['effectif'].'</span></li>
								<li class="list-group-item">Garçons: <span class="badge succes">'.$classe['garcon'].'</span></li>
								<li class="list-group-item">Filles: <span class="badge succes">'.$classe['fille'].'</span></li>
							</ul>
							
							<ul class="list-group">
								<li class="list-group-item">Présent(s): <span class="badge succes">'.($classe['effectif']-$classe['absent']).'</span></li>
								<li class="list-group-item">Absent(s): <span class="badge succes">'.$classe['absent'].'</span></li>
								<li class="list-group-item">Fille(s) Absente(s): <span class="badge succes">'.$classe['fille_absent'].'</span></li>
								<li class="list-group-item">Garçon(s) Absent(s): <span class="badge succes">'.($classe['absent']-$classe['fille_absent']).'</span></li>
							</ul>
							
							<p><button class="btn btn-success btn-block afficherAbsent" id="'.$classe['id'].'">Afficher les absents</button></p>
						</div>
					</div>
				</div>';
			}
			
			echo $code;
		}
		
	}
	else
	{
		echo 'La date est invalide';
	}
}


if(isset($_GET['id']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']))
{
	$id=(int)$_GET['id'];
	$jour=(int)$_GET['jour'];
	$mois=(int)$_GET['mois'];
	$annee=(int)$_GET['annee'];
	include_once('../fonction.php');
	
	if(checkdate($mois, $jour, $annee))
	{
		session_start();
		include_once('connexion_base.php');
		
		$date=$annee.'-'.$mois.'-'.$jour;
		
		if(isset($_SESSION['user']) && isset($_SESSION['annee']))
		{
			$prepare=$base->prepare('SELECT e.nom, e.prenom, c.motif FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
				INNER JOIN controle AS c ON e.id=c.id_eleve WHERE c.present=0 AND c.date=:date AND ce.id_classe=:id_classe AND ce.annee=:annee');
			$prepare->execute([
				'date'=>$date,
				'annee'=>$_SESSION['annee'],
				'id_classe'=>$id
			]);	
			
			$liste='<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<tr>
							<th style="width: 15%">Nom</th>
							<th style="width: 30%">Prénom</th>
							<th style="width: 50%">Motif</th>
						</tr>';
					
			while($eleve=$prepare->fetch())
			{
				$liste.='<tr>
					<td>'.$eleve['nom'].'</td>
					<td>'.$eleve['prenom'].'</td>
					<td>'.$eleve['motif'].'</td>
				</tr>';
			}
			$prepare->closeCursor();
									
			$liste.='</table>';
			
			$prepare=$base->prepare('SELECT niveau, intitule, option_lycee FROM classe WHERE id=?');
			$prepare->execute([$id]);
			$classe='Liste des absents de la ';
			if($donnee=$prepare->fetch())
				$classe=formatClasse($donnee);
			
			
			$classe.=' '.$jour.'/'.$mois.'/'.$annee;
			echo json_encode(['liste'=>$liste, 'titre'=>$classe]);
		}
	}	
	else
	{
		echo 'La date est invalide';
	}
}