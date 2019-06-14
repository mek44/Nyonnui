<?php
function getRapport($idEcole, $mois, $annee)
{
	global $base;
	$prepare=$base->prepare("SELECT p.matricule, p.nom, p.prenom, DATE_FORMAT(s.date, '%d/%m/%Y') AS date_paie, s.salaire_base, s.taux_horaire, 
		s.volume_horaire FROM personnel AS p INNER JOIN salaire AS s ON p.id=s.id_personnel WHERE p.id_ecole=:id_ecole AND s.mois=:mois AND s.annee=:annee
		ORDER BY date ASC");
	$prepare->execute([
				'id_ecole'=>$idEcole,
				'mois'=>$mois,
				'annee'=>$annee
			]
		);
	$resultat=$prepare->fetchAll();
	
	return $resultat;
}


if(isset($_GET['mois']))
{
	session_start();
	include_once('connexion_base.php');
	include_once('../fonction.php');
	
	$mois=(int)$_GET['mois'];
	
	$rapport=getRapport($_SESSION['user']['idEcole'], $mois, $_SESSION['annee']);
	$table='<table class="table table-bordered table-striped table-condensed">
			<tr>
				<th>Date</th>
				<th>Matricule</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Volume horaire</th>
				<th>Taux horaire</th>
				<th>Salaire de base</th>
				<th>Somme</th>
			</tr>';

	foreach ($rapport as $salaire) 
	{
		$table.='<tr>
			<td>'.$salaire['date_paie'].'</td>
			<td>'.$salaire['matricule'].'</td>
			<td>'.$salaire['nom'].'</td>
			<td>'.$salaire['prenom'].'</td>
			<td>'.$salaire['volume_horaire'].'</td>
			<td>'.formatageMontant($salaire['taux_horaire']).'</td>
			<td>'.formatageMontant($salaire['salaire_base']).'</td>
			<td>'.formatageMontant(($salaire['volume_horaire']*$salaire['taux_horaire'])+$salaire['salaire_base']).'</td>
			</tr>';
	}
	
	$table.='</table>';
	
	$total=0;

	foreach ($rapport as $salaire) {
		$total+=($salaire['volume_horaire']*$salaire['taux_horaire'])+$salaire['salaire_base'];
	}
		
	$resultat=['liste'=>$table, 'total'=>formatageMontant($total)];
	echo json_encode($resultat);
}