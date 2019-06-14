<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getEmploie($idClasse)
{
	global $base;
	$prepare=$base->prepare("SELECT e.jour, DATE_FORMAT(e.debut, '%H:%i') AS debut, DATE_FORMAT(e.fin, '%H:%i') AS fin, m.nom AS nom_matiere, 
		p.nom AS nom_pers, p.prenom AS prenom, e.annee FROM emploie AS e INNER JOIN matiere AS m ON m.id=e.id_matiere 
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

