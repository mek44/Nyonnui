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


function getListeImpaye($mois, $classe, $listeMois, $idEcole, $annee)
{
	global $base;

	$moisActuel=(int)date('m');
	$resultat=[];
	
	if($mois==0)
	{
		$requete='SELECT e.id, e.matricule, e.nom, e.prenom, e.sexe, c.niveau, c.intitule, c.option_lycee FROM eleve AS e 
		INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe 
		WHERE e.id_ecole=:id_ecole AND ce.annee=:annee';
		
		if($classe!=0)
			$requete.=' AND ce.id_classe=:id_classe';
	
		$requete.=' ORDER BY c.niveau, e.nom, e.prenom';

		$prepare=$base->prepare($requete);
		
		$parametre['id_ecole']=$idEcole;
		$parametre['annee']=$annee;
		if($classe!=0)
			$parametre['id_classe']=$classe;
		
		$prepare->execute($parametre);
		$listeEleve=$prepare->fetchAll();
		$prepare->closeCursor();
		
		$prepare=$base->prepare('SELECT COUNT(id_eleve) AS nombre FROM scolarite WHERE id_eleve=:id_eleve AND mois=:mois AND annee=:annee');
		foreach($listeEleve as $eleve)
		{
			$payeTous=true;
			foreach ($listeMois as $valeur) 
			{
				$prepare->execute([
						'id_eleve'=>$eleve['id'],
						'mois'=>$valeur,
						'annee'=>$annee
					]);
				$reponse=$prepare->fetch();
				if($reponse['nombre']<1)
				{
					$payeTous=false;
					break;
				}
			}
			
			if(!$payeTous)
				array_push($resultat, $eleve);
		}
		
	}
	else
	{
		$requete='SELECT e.matricule, e.nom, e.prenom, e.sexe, c.niveau, c.intitule, c.option_lycee FROM eleve AS e 
		INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe 
		WHERE e.id_ecole=:id_ecole AND ce.annee=:ce_annee AND e.id NOT IN(SELECT id_eleve FROM scolarite WHERE mois=:mois AND annee=:s_annee)';
	
		if($classe!=0)
			$requete.=' AND ce.id_classe=:id_classe';
		
		$requete.=' ORDER BY c.niveau, e.nom, e.prenom';
		
		$prepare=$base->prepare($requete);
		$parametre['id_ecole']=$idEcole;
		$parametre['ce_annee']=$annee;
		$parametre['s_annee']=$annee;
		$parametre['mois']=$mois;
		
		if($classe!=0)
			$parametre['id_classe']=$classe;
		$prepare->execute($parametre);

		$resultat=$prepare->fetchAll();
	}

	return $resultat;
}

if(isset($_GET['mois']) && isset($_GET['classe']))
{
	session_start();
	include_once('connexion_base.php');
	$mois=(int)$_GET['mois'];
	$classe=(int)$_GET['classe'];
	$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];

	$listeImpayees=getListeImpaye($mois, $classe, $listeMois, $_SESSION['user']['idEcole'], $_SESSION['annee']);
	$table='<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th>Matricule</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Sexe</th>
						<th>Classe</th>
					</tr>';
								
	foreach ($listeImpayees as $impayee) {
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
			$libelle.=$impayee['option_lycee'];
	
		$libelle.=$impayee['intitule'];
		$table.='<tr>
			<td>'.$impayee['matricule'].'</td>
			<td>'.$impayee['nom'].'</td>
			<td>'.$impayee['prenom'].'</td>
			<td>'.$impayee['sexe'].'</td>
			<td>'.$libelle.'</td>
		</tr>';
	}
	$table.='</table>';
	
	
	echo $table;
}