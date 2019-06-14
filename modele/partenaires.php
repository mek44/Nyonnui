<?php
function getEcole($annee, $region=null, $prefecture=null, $cycle)
{
	global $base;
	
	$resultat=[];
	
	if($region==null && $prefecture==null)
	{
		$prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
			INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE e.id_cycle=:cycle ORDER BY e.nom');
		$prepare->execute(['region'=>$region]);
		$resultat=$prepare->fetchAll();
	}
	else if($region!=null && $prefecture==null)
	{
		$prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
			INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE r.id=:region AND e.id_cycle=:cycle ORDER BY e.nom');
		$prepare->execute([
				'region'=>$region,
				'cycle'=>$cycle
			]);
		$resultat=$prepare->fetchAll();
	}else if($region==null && $prefecture!=null)
	{
		$prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
			INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE p.id=:prefecture AND e.id_cycle=:cycle ORDER BY e.nom');
		$prepare->execute([
				'prefecture'=>$prefecture,
				'cycle'=>$cycle
			]);
		$resultat=$prepare->fetchAll();
	}
	else 
	{
		$prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
			INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE r.id=:region AND p.id=:prefecture 
			AND e.id_cycle=:cycle ORDER BY e.nom');
		$prepare->execute([
				'region'=>$region,
				'prefecture'=>$prefecture,
				'cycle'=>$cycle
			]);
		$resultat=$prepare->fetchAll();
                
	}

	//effectif total
	
	$prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN 
		ecole AS e ON e.id=c.id_ecole WHERE e.id=:idEcole AND ce.annee=:annee');
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'idEcole'=>$resultat[$i]['id'],
				'annee'=>$annee
			]);
		if(($donnees=$prepare->fetch())){
                    $resultat[$i]['effectif']=$donnees['nombre'];
                    
                }
	}

	//effectif des filles et garçon
	
	$prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN 
		ecole AS e ON e.id=c.id_ecole INNER JOIN eleve AS el ON el.id=ce.id_eleve WHERE e.id=:idEcole AND ce.annee=:annee AND el.sexe=:sexe');
	
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
				'idEcole'=>$resultat[$i]['id'],
				'annee'=>$annee,
				'sexe'=>'F'
			]);
		if(($donnees=$prepare->fetch())){
			$resultat[$i]['fille']=$donnees['nombre'];
                        
                }
		$prepare->execute([
				'idEcole'=>$resultat[$i]['id'],
				'annee'=>$annee,
				'sexe'=>'M'
			]);
		if(($donnees=$prepare->fetch())){
			$resultat[$i]['garcon']=$donnees['nombre'];
                        
                }
	}
	
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


function getCycle()
{
	global $base;
	
	$requete=$base->query('SELECT libelle, id FROM cycle ORDER BY libelle');
	$resultat=$requete->fetchAll();
	$requete->closeCursor();
	
	return $resultat;
}


function getStatistique($prefecture, $cycle)
{
	global $base;

	$requete=$base->query('SELECT id, libelle FROM etablissement ORDER BY libelle');
	$etablissement=$requete->fetchAll();
	$requete->closeCursor();

	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM ecole WHERE id_prefecture=:id_prefecture AND id_cycle=:id_cycle 
		AND id_etablissement=:etablissement');

	$resultat=[];
	foreach ($etablissement as $etablis) {
		$prepare->execute([
				'id_prefecture'=>$prefecture,
				'id_cycle'=>$cycle,
				'etablissement'=>$etablis['id']
			]);
		$reponse=$prepare->fetch();
		$prepare->closeCursor();

	 	array_push($resultat, ['etablissement'=>$etablis['libelle'], 'nombre'=>$reponse['nombre']]);
	}

	return $resultat;
}


function afficheEcole($region, $prefecture, $cycle)
{
	$listePartenaire=getEcole($_SESSION['annee'], $region, $prefecture, $cycle);
	$code='';
	foreach($listePartenaire as $partenaire)
	{	
	$code.='<div class="col-lg-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h1 class="panel-title">'.$partenaire['nom'].'</h1>
				</div>
				<div class="panel-body">
					<ul class="list-group">
						<li class="list-group-item">Région: '.$partenaire['nom_region'].'</li>
						<li class="list-group-item">Région: '.$partenaire['nom_pref'].'</li>
						<li class="list-group-item">Adresse: '.$partenaire['adresse'].'</li>
						<li class="list-group-item">Téléphone: '.$partenaire['telephone'].'</li>
						<li class="list-group-item">Effectif: <span class="badge succes">'.$partenaire['effectif'].'</span></li>
						<li class="list-group-item">Garçon(s): <span class="badge succes">'.$partenaire['garcon'].'</span></li>
						<li class="list-group-item">Fille(s): <span class="badge succes">'.$partenaire['fille'].'</span></li>
					</ul>
					
					<p><a class="btn btn-success btn-block afficherStatistique" href="statistique_presence.php?id_ecole='.$partenaire['id'].'">Statistiques des élèves</a></p>
					<a href="modifier_ecole.php?id='.$partenaire['id'].'" class="btn btn-success">Modifier</a>
				</div>
			</div>
		</div>';
	}
	
	return $code;
}


function afficherStatistique($prefecture)
{	
	$listeCycle=getCycle();

	$primaire=[];
	$college=[];
	$lycee=[];

	foreach($listeCycle as $cycle)
	{
		if($cycle['libelle']=='Primaire')
			$primaire=getStatistique($prefecture, $cycle['id']);
		else if($cycle['libelle']=='Collège')
			$college=getStatistique($prefecture, $cycle['id']);
		else
			$lycee=getStatistique($prefecture, $cycle['id']);
	}

	$code='<div class="col-lg-2 col-lg-offset-3 col-xs-12 col-sm-2 col-sm-offset-3">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title">Primaire</h1>
					</div>
					<div class="panel-body">
						<ul class="list-group">';
							
							$total=0;
							foreach ($primaire as $etablissement) 
							{
								$code.='<li class="list-group-item">'.$etablissement['etablissement'].'<span class="badge succes">'.$etablissement['nombre'].'</span></li>';
								$total+=$etablissement['nombre'];
							}
							
							$code.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
						</ul>
						
					</div>
				</div>
			</div>


			<div class="col-lg-2 col-xs-12 col-sm-2">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title">Collège</h1>
					</div>
					<div class="panel-body">
						<ul class="list-group">';
							
							$total=0;
							foreach ($college as $etablissement) 
							{
								$code.='<li class="list-group-item">'.$etablissement['etablissement'].': <span class="badge succes">'.$etablissement['nombre'].'</span></li>';
								$total+=$etablissement['nombre'];
							}
							
							$code.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
						</ul>
						
					</div>
				</div>
			</div>


			<div class="col-lg-2 col-xs-12 col-sm-2">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title">Lycée</h1>
					</div>
					<div class="panel-body">
						<ul class="list-group">';
							
							$total=0;
							foreach ($lycee as $etablissement) 
							{
								$code.='<li class="list-group-item">'.$etablissement['etablissement'].': <span class="badge succes">'.$etablissement['nombre'].'</span></li>';
								$total+=$etablissement['nombre'];
							}
							
							$code.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
						</ul>
						
					</div>
				</div>
			</div>';
	return $code;
}

if(isset($_GET['region']) && isset($_GET['cycle']))
{
	session_start();
	include_once('connexion_base.php');
	$idRegion=(int)$_GET['region'];
	$cycle=(int)$_GET['cycle'];
	
	$listePrefecture=getPrefecture($idRegion);
	$optionPrefecture='';
	foreach($listePrefecture as $prefecture)
	{
		$optionPrefecture.='<option value="'.$prefecture['id'].'">'.$prefecture['nom'].'</option>';
	}
	
	$ecole=[];
	if(count($listePrefecture)>0)
		$ecole=afficheEcole($idRegion, $listePrefecture[0]['id'], $cycle);
	
	$statistique='';
	if(count($listePrefecture)>0)
		$statistique=afficherStatistique($listePrefecture[0]['id']);

	echo json_encode(['prefecture'=>$optionPrefecture, 'ecole'=>$ecole, 'statistique'=>$statistique]);
}


if(isset($_GET['prefecture']) && isset($_GET['cycle']))
{
	session_start();
	include_once('connexion_base.php');
	
	$prefecture=(int)$_GET['prefecture'];
	$cycle=(int)$_GET['cycle'];
	$region=$_SESSION['user']['id_region'];

	if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='Partenaire')
		$region=null;
	
	

	$statistique=afficherStatistique($prefecture);
	$ecoles=afficheEcole($region, $prefecture, $cycle);

	echo json_encode(['ecoles'=>$ecoles, 'statistique'=>$statistique]);
}