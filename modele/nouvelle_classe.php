<?php
function insertClasse(array $classe)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO classe(id_ecole, niveau, intitule, option_lycee) VALUES(:id_ecole, :niveau, :intitule, :option_lycee)');
	$prepare->execute([
			'id_ecole'=>$classe['idEcole'],
			'niveau'=>$classe['niveau'],
			'intitule'=>$classe['libelle'],
			'option_lycee'=>$classe['option']
		]);
}