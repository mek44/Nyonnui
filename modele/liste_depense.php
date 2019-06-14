<?php
function getListeDepense($debut, $fin, $categorie, $idEcole)
{
	global $base;
	
	$requete="SELECT DATE_FORMAT(d.date, '%d-%m-%Y') AS date_depense, d.montant, d.beneficiaire, c.libelle FROM depense AS d INNER JOIN categorie_depense AS c 
		ON c.id=d.id_depense WHERE d.id_ecole=:id_ecole AND (d.date BETWEEN :debut AND :fin) ";
	
	if($categorie!=0)
		$requete.="AND d.id_depense=:id_depense ";
	
	$requete.="ORDER BY date DESC";
	
	$prepare=$base->prepare($requete);
	
	$prepare->bindParam(':id_ecole', $idEcole);
	$prepare->bindParam(':debut', $debut);
	$prepare->bindParam(':fin', $fin);
	
	if($categorie!=0)
		$prepare->bindParam('id_depense', $categorie);
	
	$prepare->execute();
		
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}


function getCategorie($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT id, libelle FROM categorie_depense WHERE id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}



if(isset($_GET['jourDebut']) && isset($_GET['moisDebut']) && isset($_GET['anneeDebut']) && isset($_GET['jourFin']) && isset($_GET['moisFin']) && isset($_GET['anneeFin']) &&
	isset($_GET['categorie']))
{
	session_start();
	include_once('connexion_base.php');
	$jourDebut=(int)$_GET['jourDebut'];
	$moisDebut=(int)$_GET['moisDebut'];
	$anneeDebut=(int)$_GET['anneeDebut'];
	
	$jourFin=(int)$_GET['jourFin'];
	$moisFin=(int)$_GET['moisFin'];
	$anneeFin=(int)$_GET['anneeFin'];
	
	$categorie=(int)$_GET['categorie'];
	
	$debut=$anneeDebut.'-'.$moisDebut.'-'.$jourDebut;
	$fin=$anneeFin.'-'.$moisFin.'-'.$jourFin;
	
	$table='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Date</th>
					<th>Catégorie</th>
					<th>Montant</th>
					<th>Bénéficiaire</th>
				</tr>';
				
	if(isset($_SESSION['user']))
	{
		$listeDepense=getListeDepense($debut, $fin, $categorie, $_SESSION['user']['idEcole']);
		
														
		foreach($listeDepense as $depense)
		{
			$table.='<tr>
					<td>'.$depense['date_depense'].'</td>
					<td>'.$depense['libelle'].'</td>
					<td>'.$depense['montant'].'</td>
					<td>'.$depense['beneficiaire'].'</td>
				</tr>';
		}
	}
	
	$table.='</table>';
	
	echo $table;
}