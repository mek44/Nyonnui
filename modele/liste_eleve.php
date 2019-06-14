<?php
function getListeEleve($idClasse, $annee)
{
	global $base;
	
	$prepare=$base->prepare('SELECT e.matricule, e.nom, e.prenom, e.sexe, e.lieu_naissance, DATE_FORMAT(e.date_naissance, \'%d-%m-%Y\') AS date_naissance,
		e.pere, e.mere FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$annee
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}

function getListeClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getListeAnnee($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT DISTINCT annee FROM classe_eleve WHERE id_eleve IN(SELECT id FROM eleve WHERE id_ecole=?) ORDER BY annee DESC');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

if(isset($_GET['matricule']))
{
	session_start();
	include_once('connexion_base.php');

	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	$nombre=$prepare->fetch();
	$prepare->closeCursor();
	
	if($nombre['nombre']<1)
	{
		echo json_encode($nombre);
	}
	else
	{
		$prepare=$base->prepare('SELECT id, matricule, nom, prenom, sexe, DATE_FORMAT(date_naissance, \'%d-%m-%Y\') AS date_naissance,
			lieu_naissance, pere, mere, ecole_origine, pv_dernier_examen AS pv, rang_dernier_examen AS rang, session_dernier_examen AS session, photo, 
			id_tuteur FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole');
		$prepare->execute([
				'matricule'=>$_GET['matricule'],
				'id_ecole'=>$_SESSION['user']['idEcole']
			]);
		$resultat1=$prepare->fetch();
		$prepare->closeCursor();
		
		$prepare=$base->prepare('SELECT nom AS nomTuteur, adresse, telephone FROM tuteur WHERE id=?');
		$prepare->execute([$resultat1['id_tuteur']]);
		$resultat2=$prepare->fetch();
		$prepare->closeCursor();

		
		$prepare=$base->prepare('SELECT c.niveau, c.intitule, c.option_lycee, DATE_FORMAT(ce.date_inscription, \'%d-%m-%Y\') AS dateInscription FROM classe AS c INNER JOIN classe_eleve AS ce ON c.id=ce.id_classe 
			WHERE ce.id_eleve=? ORDER BY ce.date_inscription DESC LIMIT 1');
		$prepare->execute([$resultat1['id']]);
		$resultat3=$prepare->fetch();
		$prepare->closeCursor();

		$resultat=array_merge($resultat1, $resultat2, $resultat3);
		echo json_encode($resultat);
	}
}

if(isset($_GET['classe']) && isset($_GET['annee']))
{
	$classe=(int)$_GET['classe'];
	$annee=htmlspecialchars($_GET['annee']);
	
	include_once('connexion_base.php');
	
	$prepare=$base->prepare('SELECT e.matricule, e.nom, e.prenom, e.sexe, e.lieu_naissance, DATE_FORMAT(e.date_naissance, \'%d-%m-%Y\') AS date_naissance,
		e.pere, e.mere FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$classe,
			'annee'=>$annee
		]);
	
	$tableEleve='<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th>Matricule</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Sexe</th>
						<th>Date de Naissance</th>
						<th>Lieu de Naissance</th>
						<th>Père</th>
						<th>Mère</th>
					</tr>';
								
	while($eleve=$prepare->fetch())
	{
		$tableEleve.='<tr class="eleve" id="'.$eleve['matricule'].'">
						<td>'.$eleve['matricule'].'</td>
						<td>'.$eleve['nom'].'</td>
						<td>'.$eleve['prenom'].'</td>
						<td>'.$eleve['sexe'].'</td>
						<td>'.$eleve['date_naissance'].'</td>
						<td>'.$eleve['lieu_naissance'].'</td>
						<td>'.$eleve['pere'].'</td>
						<td>'.$eleve['mere'].'</td>
					</tr>';
	}
	$tableEleve.='</table>';
	
	$prepare->closeCursor();
	echo $tableEleve;
}


if(isset($_GET['afficherTous']))
{
	session_start();
	include_once('connexion_base.php');
	$prepare=$base->prepare('SELECT matricule, nom, prenom, sexe, lieu_naissance, DATE_FORMAT(date_naissance, \'%d-%m-%Y\') AS date_naissance,
		pere, mere FROM eleve WHERE id_ecole=?');
	$prepare->execute([$_SESSION['user']['idEcole']]);
	
	$tableEleve='<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th>Matricule</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Sexe</th>
						<th>Date de Naissance</th>
						<th>Lieu de Naissance</th>
						<th>Père</th>
						<th>Mère</th>
					</tr>';
								
	while($eleve=$prepare->fetch())
	{
		$tableEleve.='<tr class="eleve" id="'.$eleve['matricule'].'">
						<td>'.$eleve['matricule'].'</td>
						<td>'.$eleve['nom'].'</td>
						<td>'.$eleve['prenom'].'</td>
						<td>'.$eleve['sexe'].'</td>
						<td>'.$eleve['date_naissance'].'</td>
						<td>'.$eleve['lieu_naissance'].'</td>
						<td>'.$eleve['pere'].'</td>
						<td>'.$eleve['mere'].'</td>
					</tr>';
	}
	$tableEleve.='</table>';
	
	$prepare->closeCursor();
	echo $tableEleve;
}