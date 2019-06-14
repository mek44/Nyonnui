<?php
session_start();
if(isset($_GET['classe']) && isset($_SESSION['annee']))
{
	include_once('connexion_base.php');
	
	$classe=(int)$_GET['classe'];
	
	$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee ORDER BY e.nom, e.prenom');
	$prepare->execute([
			'id_classe'=>$classe,
			'annee'=>$_SESSION['annee'],
		]);
	
	$resultat='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Matricule</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Note</th>
				</tr>';
						
	while($donnees=$prepare->fetch())
	{
		$resultat.='<tr class="eleve">
						<td id="'.$donnees['matricule'].'">'.$donnees['matricule'].'</td>
						<td>'.$donnees['nom'].'</td>
						<td>'.$donnees['prenom'].'</td>
						<td><input type="text" value="0" /></td>
					</tr>';
	}
	$resultat.='</table>';
	$prepare->closeCursor();
		
	echo $resultat;
}