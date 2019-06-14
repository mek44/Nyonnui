<?php
if(isset($_GET['matricule']))
{
	session_start();
	include_once('connexion_base.php');
	include_once('../fonction.php');

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
		$listeMois=['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
		$total=0;
		
		$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom, e.sexe, e.photo, c.niveau, c.intitule, c.option_lycee
			FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe 
			WHERE e.matricule=:matricule AND e.id_ecole=:id_ecole AND ce.annee=:annee');
		$prepare->execute([
				'matricule'=>$_GET['matricule'],
				'id_ecole'=>$_SESSION['user']['idEcole'],
				'annee'=>$_SESSION['annee']
			]);
		$resultat=$prepare->fetch();
		$prepare->closeCursor();
		
		$table='<table class="table table-striped table-condensed table-bordered">
				<tr>
					<th>Date</th>
					<th>Mois</th>
					<th>Payé</th>
					<th>Réduction</th>
					<th>Reçu</th>
				</tr>';
	
		$prepare=$base->prepare('SELECT DATE_FORMAT(date, \'%d-%m-%Y\') AS date_paie, mois, montant, reduction, num_recus FROM scolarite
			WHERE id_eleve=(SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole) AND annee=:annee ORDER BY date');
		$prepare->execute([
				'matricule'=>$_GET['matricule'],
				'id_ecole'=>$_SESSION['user']['idEcole'],
				'annee'=>$_SESSION['annee']
			]);
							
		while($versement=$prepare->fetch())
		{
			$table.='<tr>
					<td>'.$versement['date_paie'].'</td>
					<td>'.$listeMois[$versement['mois']-1].'</td>
					<td>'.formatageMontant($versement['montant']-$versement['reduction']).'</td>
					<td>'.formatageMontant($versement['reduction']).'</td>
					<td>'.$versement['num_recus'].'</td>
				</tr>';		

			$total+=$versement['montant']-$versement['reduction'];
		}
		$prepare->closeCursor();
		$table.='</table>';
		
		$resultat['versement']=$table;
		$resultat['total']=formatageMontant($total);
		
		echo json_encode($resultat);
	}
}
