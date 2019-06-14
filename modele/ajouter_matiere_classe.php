<?php
if(isset($_POST['matiere']) && !empty($_POST['matiere']) && isset($_POST['coefficient']) && preg_match('#^[1-4]$#', $_POST['coefficient']) && 
	isset($_POST['classe']) && !empty($_POST['classe']))
{
	include_once('connexion_base.php');
	
	$classe=(int)$_POST['classe'];
	$matiere=(int)$_POST['matiere'];
	$coefficient=(int)$_POST['coefficient'];
	
	$prepare=$base->prepare('INSERT INTO matiere_classe(id_classe, id_matiere, coefficient) VALUES(:id_classe, :id_matiere, :coefficient)');
	$prepare->execute([
			'id_classe'=>$classe,
			'id_matiere'=>$matiere,
			'coefficient'=>$coefficient
		]);
	echo 'ok';
}
else
	echo 'bad';