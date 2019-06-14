<?php
if(isset($_GET['telephone']))
{
	include_once('../modele/recherche_tuteur.php');
	include_once('../modele/connexion_base.php');
	
	$tuteur=getTuteur($_GET['telephone']);
	echo json_encode($tuteur);
}