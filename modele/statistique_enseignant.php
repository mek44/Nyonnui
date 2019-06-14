<?php
function getStatistique($user, $prefecture, $jour, $mois, $annee, $anneeScolaire)
{
	global $base;
	
	$numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));
	$date=$annee.'-'.$mois.'-'.$jour;
	
	$resultat=[];
	
	//recuperation de l'effectif total
	
	if($user['nom_fonction']=='Super Administrateur' || $user['nom_fonction']=='Partenaire' || $user['nom_fonction']=='Responsable Régionale' || 
		$user['nom_fonction']=='DPE / DCE')
	{
		$prepare=$base->prepare('SELECT COUNT(em.id_professeur) AS effectif, ec.id, ec.nom FROM emploie AS em INNER JOIN personnel AS p 
			ON p.id=em.id_professeur INNER JOIN ecole AS ec ON ec.id=p.id_ecole INNER JOIN prefecture AS pr ON pr.id=ec.id_prefecture
			WHERE em.jour=:jour AND em.annee=:annee AND pr.id=:id_prefecture GROUP BY ec.id ORDER BY ec.nom');
		$prepare->execute([
				'jour'=>$numeroJour,
				'annee'=>$anneeScolaire,
				'id_prefecture'=>$prefecture
			]);
		$resultat=$prepare->fetchAll();
		$prepare->closeCursor();
	}
	/*else if($user['fonction']=='dpe')
	{
		$prepare=$base->prepare('SELECT COUNT(em.id_professeur) AS effectif, ec.id, ec.nom FROM emploie AS em INNER JOIN personnel AS p 
			ON p.id=em.id_professeur INNER JOIN ecole AS ec ON ec.id=p.id_ecole
			WHERE em.jour=:jour AND em.annee=:annee AND ec.id_prefecture=:prefecture GROUP BY ec.id ORDER BY ec.nom');
		$prepare->execute([
				'jour'=>$numeroJour,
				'annee'=>$anneeScolaire,
				'prefecture'=>$prefecture
			]);
		$resultat=$prepare->fetchAll();
		$prepare->closeCursor();
	}*/
	else if($user['nom_fonction']=='Directeur général')
	{
		$prepare=$base->prepare('SELECT COUNT(em.id_professeur) AS effectif, ec.id, ec.nom FROM emploie AS em INNER JOIN personnel AS p 
			ON p.id=em.id_professeur INNER JOIN ecole AS ec ON ec.id=p.id_ecole WHERE jour=:jour AND annee=:annee AND ec.id=:id_ecole GROUP BY ec.id');
		$prepare->execute([
				'jour'=>$numeroJour,
				'annee'=>$anneeScolaire,
				'id_ecole'=>$user['idEcole']
			]);
		$resultat=$prepare->fetchAll();
		$prepare->closeCursor();
	}

	//recuperation de l'effectif en fontion du sexe des filles
	$prepare=$base->prepare("SELECT COUNT(id_professeur) AS effectif FROM emploie WHERE jour=:jour AND annee=:annee AND 
		id_professeur IN(SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='F')");
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'jour'=>$numeroJour,
				'annee'=>$anneeScolaire,
				'id_ecole'=>$resultat[$i]['id'],
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['fille']=$donnee['effectif'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation de l'effectif en fontion du sexe
	$prepare=$base->prepare("SELECT COUNT(id_professeur) AS effectif FROM emploie WHERE jour=:jour AND annee=:annee AND 
		id_professeur IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='M')");
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'jour'=>$numeroJour,
				'annee'=>$anneeScolaire,
				'id_ecole'=>$resultat[$i]['id'],
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['garcon']=$donnee['effectif'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation du nombre de present
	$prepare=$base->prepare('SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
		WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole)');
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'date'=>$date,
				'id_ecole'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['present']=$donnee['present'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation du nombre de fille présent
	$prepare=$base->prepare("SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
		WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='F')");
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'date'=>$date,
				'id_ecole'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['fille_present']=$donnee['present'];
		}
	}
	$prepare->closeCursor();
	
	//recuperation du nombre de garçon présent
	$prepare=$base->prepare("SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
		WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='M')");
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'date'=>$date,
				'id_ecole'=>$resultat[$i]['id']
			]);
			
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['garcon_present']=$donnee['present'];
		}
	}
	$prepare->closeCursor();
	
	return $resultat;
}

function getRegion()
{
	global $base;
	
	$requete=$base->query('SELECT id, nom FROM region ORDER BY nom');
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
	$region=(int)$_GET['region'];
	include_once('connexion_base.php');
	$listePrefecture=getPrefecture($region);
	
	$option='';
	foreach($listePrefecture as $prefecure)
	{
		$option.='<option value="'.$prefecure['id'].'">'.$prefecure['nom'].'</option>';
	}
	
	echo $option;
}

if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['prefecture']))
{
	$jour=(int)$_GET['jour'];
	$mois=(int)$_GET['mois'];
	$annee=(int)$_GET['annee'];
	$prefecture=(int)$_GET['prefecture'];
	
	if(checkdate($mois, $jour, $annee))
	{
		session_start();
		include_once('connexion_base.php');
		
		$date=$annee.'-'.$mois.'-'.$jour;
		
		if(isset($_SESSION['user']) && isset($_SESSION['annee']))
		{
			$statistique=getStatistique($_SESSION['user'], $prefecture, $jour, $mois, $annee, $_SESSION['annee']);
			$code='';
			
			foreach($statistique as $ecole)
			{
				$code.='<div class="col-lg-3">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h1 class="panel-title">'.$ecole['nom'].'</h1>
							</div>
							<div class="panel-body">
								<ul class="list-group">
									<li class="list-group-item">Effectif: <span class="badge succes">'.$ecole['effectif'].'</span></li>
									<li class="list-group-item">Garçons: <span class="badge succes">'.($ecole['garcon']).'</span></li>
									<li class="list-group-item">Filles: <span class="badge succes">'.$ecole['fille'].'</span></li>
								</ul>
								
								<ul class="list-group">
									<li class="list-group-item">Présent(s): <span class="badge succes">'.$ecole['present'].'</span></li>
									<li class="list-group-item">Absent(s): <span class="badge succes">'.($ecole['effectif']-$ecole['present']).'</span></li>
									<li class="list-group-item">Fille(s) Absente(s): <span class="badge succes">'.($ecole['fille']-$ecole['fille_present']).'</span></li>
									<li class="list-group-item">Garçon(s) Absent(s): <span class="badge succes">'.($ecole['garcon']-$ecole['garcon_present']).'</span></li>
									
								</ul>
								
								<p><button class="btn btn-success btn-block afficherAbsent" id="'.$ecole['id'].'">Afficher les absents</button></p>
								<p><a class="btn btn-success btn-block" href="taux_presence_enseignant.php?id_ecole='.$ecole['id'].'">Voir le taux de présence par mois</a></p>
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
			$prepare=$base->prepare("SELECT p.nom, p.prenom, DATE_FORMAT(c.debut, '%H:%i') AS debut, DATE_FORMAT(c.fin, '%H:%i') AS fin, c.motif FROM personnel AS p INNER JOIN controle_enseignant AS c 
				ON p.id=c.id_enseignant WHERE c.present=0 AND c.date=:date AND p.id_ecole=:id_ecole");
			$prepare->execute([
				'date'=>$date,
				'id_ecole'=>$id
			]);	
			
			$liste='<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<tr>
							<th style="width: 30%">Enseignant</th>
							<th style="width: 5%">Début</th>
							<th style="width: 5%">Fin</th>
							<th style="width: 50%">Motif</th>
						</tr>';
					
			while($personnel=$prepare->fetch())
			{
				$liste.='<tr>
					<td>'.$personnel['nom'].' '.$personnel['prenom'].'</td>
					<td>'.$personnel['debut'].'</td>
					<td>'.$personnel['fin'].'</td>
					<td>'.$personnel['motif'].'</td>
				</tr>';
			}
			$prepare->closeCursor();
									
			$liste.='</table>';
			
			
			echo $liste;
		}
	}	
	else
	{
		echo 'La date est invalide';
	}
}