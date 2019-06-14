<?php
session_start();
if(isset($_POST['classe']) && isset($_POST['jour']) && isset($_POST['matiere']) && isset($_POST['professeur']) && 
	isset($_POST['heureDebut']) && isset($_POST['minuteDebut']) && isset($_POST['heureFin']) && isset($_POST['minuteFin'])
	&& isset($_SESSION['user']))
{
	include_once('connexion_base.php');
	$debut=$_POST['heureDebut'].':'.$_POST['minuteDebut'].':00';
	$fin=$_POST['heureFin'].':'.$_POST['minuteFin'].':00';
	
	$prepare=$base->prepare('REPLACE INTO emploie(id_classe, jour, id_matiere, id_professeur, debut, fin) VALUES(:id_classe, :jour, :id_matiere, 
		(SELECT id FROM personnel WHERE matricule=:professeur AND id_ecole=:id_ecole), :debut, :fin)');
	$prepare->execute([
			'id_classe'=>$_POST['classe'],
			'jour'=>$_POST['jour'],
			'id_matiere'=>$_POST['matiere'],
			'professeur'=>$_POST['professeur'],
			'id_ecole'=>$_SESSION['user']['idEcole'],
			'debut'=>$debut,
			'fin'=>$fin
		]);
		
	$emploie='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Jour</th>
					<th>Matière</th>
					<th>Enseignant</th>
					<th>Début</th>
					<th>Fin</th>
				</tr>';
								
	$prepare=$base->prepare('SELECT e.jour, e.debut, e.fin, m.nom AS nom_matiere, p.nom AS nom_pers, p.prenom AS prenom FROM emploie AS e 
		INNER JOIN matiere AS m ON m.id=e.id_matiere INNER JOIN personnel AS p ON p.id=e.id_professeur WHERE e.id_classe=? ORDER BY e.jour');
	$prepare->execute([$_POST['classe']]);
	while($donnees=$prepare->fetch())
	{
		$emploie.='<tr>
					<td>'.$donnees['jour'].'</td>
					<td>'.$donnees['nom_matiere'].'</td>
					<td>'.$donnees['nom_pers'].' '.$donnees['prenom'].'</td>
					<td>'.$donnees['debut'].'</td>
					<td>'.$donnees['fin'].'</td>
				</tr>';
	}
	$prepare->closeCursor();
	
	echo $emploie;
}