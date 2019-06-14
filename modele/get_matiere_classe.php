<?php
if(isset($_GET['id']))
{
	$id=(int)$_GET['id'];
	$matiere='';
	$matiereClasse='<table class="table table-bordered table-striped table-condensed" id="tableMatiere">
					<tr>
						<th>N°</th>
						<th>Matière</th>
						<th>Coefficient</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>';
	
	include_once('connexion_base.php');
	
	$prepare=$base->prepare('SELECT id, nom FROM matiere WHERE id NOT IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=?)');
	$prepare->execute([$id]);
	while($donnees=$prepare->fetch())
	{
		$matiere.='<option value="'.$donnees['id'].'">'.$donnees['nom'].'</option>';
	}
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT m.id, m.nom, mc.coefficient FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere WHERE mc.id_classe=?');
	$prepare->execute([$id]);
	$i=1;
	while($donnees=$prepare->fetch())
	{
		$matiereClasse.='<tr>
							<td>'.$i.'</td>
							<td>'.$donnees['nom'].'</td>
							<td>'.$donnees['coefficient'].'</td>
							<td style="text-align:center;"><span class="glyphicon glyphicon-edit edit-matiere" id="editMatiere-'.$donnees['id'].'"></span></td>
							<td style="text-align:center;"><span class="glyphicon glyphicon-remove remove-matiere" id="removeMatiere-'.$donnees['id'].'"></span></td>
						</tr>';
		$i++;
	}
	$prepare->closeCursor();
	$matiereClasse.='</table>';
	
	$reponse=['matiere'=>$matiere, 'matiereClasse'=>$matiereClasse];
	
	echo json_encode($reponse);
}