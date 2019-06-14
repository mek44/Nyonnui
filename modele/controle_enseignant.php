<?php
function getControle($idEcole, $jour, $mois, $annee)
{
	global $base;
	$numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));
	$date=$annee.'-'.$mois.'-'.$jour;
	
	$prepare=$base->prepare("SELECT p.id, p.nom, p.prenom, m.nom AS nom_matiere, m.id AS id_matiere, c.id AS id_classe,
		c.niveau, c.intitule, c.option_lycee, DATE_FORMAT(e.debut, '%H:%i') AS debut,
		DATE_FORMAT(e.fin, '%H:%i') AS fin FROM personnel AS p INNER JOIN emploie AS e ON p.id=e.id_professeur 
		INNER JOIN matiere AS m ON m.id=e.id_matiere INNER JOIN classe AS c ON c.id=e.id_classe WHERE e.jour=:jour AND p.id_ecole=:id_ecole");
	$prepare->execute([
		'jour'=>$numeroJour,
		'id_ecole'=>$idEcole
	]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT present, motif FROM controle_enseignant WHERE id_enseignant=:id AND date=:date AND debut=:debut AND fin=:fin');
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
			'id'=>$resultat[$i]['id'],
			'date'=>$date,
			'debut'=>$resultat[$i]['debut'],
			'fin'=>$resultat[$i]['fin']
		]);
		
		if($donnee=$prepare->fetch())
		{
			$resultat[$i]['motif']=$donnee['motif'];
			$resultat[$i]['present']=$donnee['present'];
		}
		else
		{
			$resultat[$i]['motif']='';
			$resultat[$i]['present']=1;
		}
	}
	$prepare->closeCursor();
	
	return $resultat;
}

if(isset($_POST['id']) && isset($_POST['motif']) && isset($_POST['jour']) && isset($_POST['mois']) && isset($_POST['annee']) && isset($_POST['present']) &&
	isset($_POST['classe']) && isset($_POST['matiere']) && isset($_POST['debut']) && isset($_POST['fin']))
{
	session_start();
	include_once('connexion_base.php');
	
	$date=$_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
	$debut=$_POST['debut'];
	$fin=$_POST['fin'];
	$present=(int)$_POST['present'];
	$idClasse=(int)$_POST['classe'];
	$idMatiere=(int)$_POST['fin'];
	
	$prepare=$base->prepare('REPLACE INTO controle_enseignant(id_enseignant, date, id_matiere, id_classe, debut, fin, present, motif, annee) 
		VALUES(:id_enseignant, :date, :id_matiere, :id_classe, :debut, :fin, :present, :motif, :annee)');
	$prepare->execute([
			'id_enseignant'=>$_POST['id'],
			'date'=>$date,
			'id_matiere'=>$idMatiere,
			'id_classe'=>$idClasse,
			'debut'=>$debut,
			'fin'=>$fin,
			'present'=>$present,
			'motif'=>$_POST['motif'],
			'annee'=>$_SESSION['annee']
		]);
}



if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']))
{
	$annee=(int)$_GET['annee'];
	$mois=(int)$_GET['mois'];
	$jour=(int)$_GET['jour'];
	
	session_start();
	if(checkdate($mois, $jour, $annee) && isset($_SESSION['user']))
	{
		include_once('connexion_base.php');
		include_once('../fonction.php');
		$listeControle=getControle($_SESSION['user']['idEcole'], $jour, $mois, $annee);
		
		$table='<table class="table table-condensed table-bordered">
				<tr>
					<th style="width: 25%">Enseignant</th>
					<th style="width: 10%">Classe</th>
					<th style="width: 15%">Matière</th>
					<th style="width: 5%">Début</th>
					<th style="width: 5%">Fin</th>
					<th style="width: 5%">Présent</th>
					<th style="width: 30%">Motif</th>
				</tr>';

								
		foreach ($listeControle as $controle)
		{
			$checked='';
			if($controle['present']==1)
				$checked='checked';
			
			$table.='<tr class="enseignant" id="'.$controle['id'].'">
				<td>'.$controle['nom'].' '.$controle['prenom'].'</td>
				<td id="'.$controle['id_classe'].'">'.formatClasse($controle).'</td>
				<td id="'.$controle['id_matiere'].'">'.$controle['nom_matiere'].'</td>
				<td>'.$controle['debut'].'</td>
				<td>'.$controle['fin'].'</td>
				<td><input type="checkbox" '.$checked.' /></td>
				<td><input type="text" name="motif" class="form-controle" style="width: 100%" value="'.$controle['motif'].'" /></td>
			</tr>';
		}
								
		$table.='</table>';
		
		echo $table;
	}	
}