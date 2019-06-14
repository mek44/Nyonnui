<?php
include_once('modele/connexion_base.php');
include_once('modele/nouvelle_matiere.php');

$observation='';

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];

if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_SESSION['user']))
{
	$nom=htmlspecialchars($_POST['nom']);
	
	if(!isMatiereExiste($nom))
	{
		insertMatiere($nom);
		setcookie('nouvelle_matiere', 'La matière a été enregistrée avec succès', time()+3);
		setcookie('enregistrement', 'succes', time()+3);
		header('location: nouvelle_matiere.php');
	}
	else
	{
		setcookie('enregistrement', 'echec', time()+3);
		setcookie('nouvelle_matiere', 'Cette matière existe déjà', time()+3);
		header('location: nouvelle_matiere.php');
	}
		
}
else
{
	setcookie('enregistrement', 'echec', time()+3);
	setcookie('nouvelle_matiere', 'Les données ne sont pas valides', time()+3);
}
	

include_once('vue/nouvelle_matiere.php');