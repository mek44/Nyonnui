<?php
function getEffectifTotal($idEcole, $annee)
{
	global $base;
	$total=0;
	$garcon=0;
	$fille=0;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS effectif FROM classe_eleve WHERE annee=:annee AND id_eleve IN(SELECT id FROM eleve WHERE id_ecole=:id_ecole)');
	$prepare->execute([
			'annee'=>$annee,
			'id_ecole'=>$idEcole
		]);
	
	if($resultat=$prepare->fetch())
		$total=$resultat['effectif'];
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT COUNT(*) AS garcon FROM classe_eleve WHERE annee=:annee AND id_eleve IN(SELECT id FROM eleve WHERE id_ecole=:id_ecole AND sexe=\'M\')');
	$prepare->execute([
			'annee'=>$annee,
			'id_ecole'=>$idEcole
		]);
	
	if($resultat=$prepare->fetch())
		$garcon=$resultat['garcon'];
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT COUNT(*) AS fille FROM classe_eleve WHERE annee=:annee AND id_eleve IN(SELECT id FROM eleve WHERE id_ecole=:id_ecole AND sexe=\'F\')');
	$prepare->execute([
			'annee'=>$annee,
			'id_ecole'=>$idEcole
		]);
	
	if($resultat=$prepare->fetch())
		$fille=$resultat['fille'];
	$prepare->closeCursor();
	
	$effectif=['total'=>$total, 'garcon'=>$garcon, 'fille'=>$fille];
	return $effectif;
}


function getEffectifParClasse($idEcole, $annee)
{
	global $base;
	
	$listeClasse=[];
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe as c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE id_ecole=?');
	$prepare->execute([$idEcole]);
	$listeClasse=$prepare->fetchAll();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT COUNT(*) AS total FROM classe_eleve WHERE annee=:annee AND id_classe=:id_classe');
	for($i=0; $i<count($listeClasse); $i++)
	{
		$total=0;
		$prepare->execute([
			'annee'=>$annee,
			'id_classe'=>$listeClasse[$i]['id']
		]);
		
		if($resultat=$prepare->fetch())
			$total=$resultat['total'];
		
		$listeClasse[$i]['total']=$total;
	}
	
	
	$prepare=$base->prepare('SELECT COUNT(*) AS garcon FROM classe_eleve WHERE annee=:annee AND id_classe=:id_classe AND 
		id_eleve IN(SELECT id FROM eleve WHERE id_ecole=:id_ecole AND sexe=\'M\')');
	for($i=0; $i<count($listeClasse); $i++)
	{
		$garcon=0;
		$prepare->execute([
			'annee'=>$annee,
			'id_classe'=>$listeClasse[$i]['id'],
			'id_ecole'=>$idEcole
		]);
		
		if($resultat=$prepare->fetch())
			$garcon=$resultat['garcon'];
		
		$listeClasse[$i]['garcon']=$garcon;
	}
	
	
	$prepare=$base->prepare('SELECT COUNT(*) AS fille FROM classe_eleve WHERE annee=:annee AND id_classe=:id_classe AND 
		id_eleve IN(SELECT id FROM eleve WHERE id_ecole=:id_ecole AND sexe=\'F\')');
	for($i=0; $i<count($listeClasse); $i++)
	{
		$fille=0;
		$prepare->execute([
			'annee'=>$annee,
			'id_classe'=>$listeClasse[$i]['id'],
			'id_ecole'=>$idEcole
		]);
		
		if($resultat=$prepare->fetch())
			$fille=$resultat['fille'];
		
		$listeClasse[$i]['fille']=$fille;
	}
	
	
	return $listeClasse;
}


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


function getMatiereClasse($idClasse)
{
	global $base;
	
	$prepare=$base->prepare('SELECT m.id, m.nom, mc.coefficient FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere WHERE mc.id_classe=?');
	$prepare->execute([$idClasse]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}


function getEmploie($idClasse)
{
	global $base;
	$prepare=$base->prepare("SELECT e.jour, DATE_FORMAT(e.debut, '%H:%i') AS debut, DATE_FORMAT(e.fin, '%H:%i') AS fin, m.nom AS nom_matiere, 
		p.nom AS nom_pers, p.prenom AS prenom FROM emploie AS e INNER JOIN matiere AS m ON m.id=e.id_matiere 
		INNER JOIN personnel AS p ON p.id=e.id_professeur WHERE e.id_classe=? ORDER BY e.jour");
	$prepare->execute([$idClasse]);
	$resultat=$prepare->fetchAll();
	return $resultat;
}


function afficheEmploie($idClasse)
{
	$listeJour=['Lundi'=>1, 'Mardi'=>2, 'Mercrédi'=>3, 'Jeudi'=>4, 'Vendredi'=>5, 'Samedi'=>6];
	$listeEmploie=getEmploie($idClasse);
	$table='<table class="table table-bordered table-striped table-condensed">
			<tr>
				<th>Jour</th>
				<th>Matière</th>
				<th>Enseignant</th>
				<th>Début</th>
				<th>Fin</th>
			</tr>';
								
								
	foreach($listeEmploie as $emploie)
	{
		$table.='<tr>
			<td>'.array_search($emploie['jour'], $listeJour).'</td>
			<td>'.$emploie['nom_matiere'].'</td>
			<td>'.$emploie['nom_pers'].' '.$emploie['prenom'].'</td>
			<td>'.$emploie['debut'].'</td>
			<td>'.$emploie['fin'].'</td>
		</tr>';
	
	}
	
	$table.='</table>';
	
	return $table;
}

if(isset($_GET['classe']))
{
	session_start();
	include_once('connexion_base.php');
	
	$id=(int)$_GET['classe'];
	
	$listeEleve=getListeEleve($id, $_SESSION['annee']);
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
					
	foreach($listeEleve as $eleve)
	{
		$tableEleve.='<tr>
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
	
	$listeMatiere=getMatiereClasse($id);
	$tableMatiere='<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th>N°</th>
						<th>Matière</th>
						<th>Coefficient</th>
					</tr>';
	
	$i=1;
	$optionMatiere='';
	foreach($listeMatiere as $matiere)
	{
		$tableMatiere.='<tr>
					<td>'.$i.'</td>
					<td>'.$matiere['nom'].'</td>
					<td>'.$matiere['coefficient'].'</td>
				</tr>';
		$optionMatiere.='<option value="'.$matiere['id'].'">'.$matiere['nom'].'</option>';
		
		$i++;
	}
	$tableMatiere.='</table>';
	
	$tableEmploie=afficheEmploie($id);
	
	$resultat=['eleve'=>$tableEleve, 'matiere'=>$tableMatiere, 'optionMatiere'=>$optionMatiere, 'tableEmploie'=>$tableEmploie];
	echo json_encode($resultat);
}

if(isset($_GET['matricule']))
{
	include_once('connexion_base.php');
	session_start();

	$prepare=$base->prepare('SELECT nom, prenom FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	if($donnees=$prepare->fetch())
	{
		echo $donnees['nom'].' '.$donnees['prenom'];
	}
	else
	{
		echo '';
	}
	$prepare->closeCursor();
}


if(isset($_POST['classe']) && isset($_POST['jour']) && isset($_POST['matiere']) && isset($_POST['professeur']) && isset($_POST['heureDebut']) &&
	isset($_POST['minuteDebut']) && isset($_POST['heureFin']) && isset($_POST['minuteFin']))
{
	include_once('connexion_base.php');
	session_start();
	
	$idClasse=(int)$_POST['classe'];
	$jour=(int)$_POST['jour'];
	$matiere=(int)$_POST['matiere'];
	$debut=$_POST['heureDebut'].':'.$_POST['minuteDebut'].':00';	
	$fin=$_POST['heureFin'].':'.$_POST['minuteFin'].':00';
	
	$prepare=$base->prepare('REPLACE INTO emploie(id_classe, jour, id_matiere, id_professeur, debut, fin, annee) VALUES(:id_classe, :jour, :id_matiere, 
		(SELECT id FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole), :debut, :fin, :annee)');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'jour'=>$jour,
			'id_matiere'=>$matiere,
			'matricule'=>$_POST['professeur'],
			'id_ecole'=>$_SESSION['user']['idEcole'],
			'debut'=>$debut,
			'fin'=>$fin,
			'annee'=>$_SESSION['annee']
		]);
	
	echo afficheEmploie($idClasse);
}