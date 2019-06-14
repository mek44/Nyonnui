<?php
function getListeClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getListePaye($mois, $classe, $listeMois, $idEcole, $annee)
{
	global $base;

	$moisActuel=(int)date('m');
	$requete='SELECT e.matricule, e.nom, e.prenom, c.niveau, c.intitule, c.option_lycee, s.mois, s.montant, s.reduction, s.num_recus, 
		DATE_FORMAT(date, \'%d-%m-%Y\') AS date FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
		INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN scolarite AS s ON 
		e.id=s.id_eleve WHERE e.id_ecole=:id_ecole AND ce.annee=:ce_annee AND s.mois=:mois AND s.annee=:s_annee';

	if($classe!=0)
		$requete.=' AND ce.id_classe=:id_classe';

	$prepare=$base->prepare($requete);

	$parametre['id_ecole']=$idEcole;
	$parametre['ce_annee']=$annee;
	$parametre['mois']=$mois;
	$parametre['s_annee']=$annee;
		
	if($classe!=0)
		$parametre['id_classe']=$classe;
	$prepare->execute($parametre);

	$resultat=$prepare->fetchAll();
	return $resultat;
}


function getInformationCfip($idEcole)
{
	global $base;
	
	$information=[];
	$prepare=$base->prepare('SELECT cfip, part_ong, part_ecole FROM ecole WHERE id=?');
	$prepare->execute([$idEcole]);
	
	if($resultat=$prepare->fetch())
		$information=$resultat;
	
	return $information;
}


if(isset($_GET['mois']) && isset($_GET['classe']))
{
	session_start();
	include_once('connexion_base.php');
	include_once('../fonction.php');
	
	$mois=(int)$_GET['mois'];
	$classe=(int)$_GET['classe'];
	$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];

	$informationCifp=getInformationCfip($_SESSION['user']['idEcole']);
	$listePaye=getListePaye($mois, $classe, $listeMois, $_SESSION['user']['idEcole'], $_SESSION['annee']);
	$table='<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th>Date</th>
						<th>Matricule</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Classe</th>
						<th>Mois</th>
						<th>Payé</th>
						<th>Réduction</th>
						<th>Reçu</th>
					</tr>';
								
	foreach ($listePaye as $paye) {
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
		if($paye['niveau']>10)
			$libelle.=$paye['option_lycee'];
	
		$libelle.=$paye['intitule'];
		
		$mois='';
		foreach($listeMois as $nom=>$numero)
		{
			if($numero==$paye['mois'])
			{
				$mois=$nom;
				break;
			}	
		}
		$table.='<tr>
				<td>'.$paye['date'].'</td>
				<td>'.$paye['matricule'].'</td>
				<td>'.$paye['nom'].'</td>
				<td>'.$paye['prenom'].'</td>
				<td>'.$libelle.'</td>
				<td>'.$mois.'</td>
				<td>'.formatageMontant($paye['montant']-$paye['reduction']).'</td>
				<td>'.formatageMontant($paye['reduction']).'</td>
				<td>'.$paye['num_recus'].'</td>
			</tr>';
	}
	$table.='</table>';
	
	$total=0;
	$cfip=($informationCifp['part_ong']+$informationCifp['part_ecole'])*count($listePaye);
	$partOng=$informationCifp['part_ong']*count($listePaye);
	$partEcole=$informationCifp['part_ecole']*count($listePaye);

	foreach ($listePaye as $paye) {
		$total+=$paye['montant']-$paye['reduction'];
	}
		
	$resultat=['liste'=>$table, 'total'=>formatageMontant($total), 'mensualite'=>formatageMontant($total-$cfip), 'cfip'=>formatageMontant($cfip), 'partEcole'=>formatageMontant($partEcole), 
		'partOng'=>formatageMontant($partOng)];
		
	echo json_encode($resultat);
}