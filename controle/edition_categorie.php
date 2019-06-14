<?php
session_start();
include_once('../modele/connexion_base.php');
include_once('../modele/edition_categorie.php');

if(isset($_POST['ajouter']) && isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_SESSION['user']))
{
	
	$libelle=htmlspecialchars($_POST['libelle']);
	
	if(!isCategorieExiste($libelle, $_SESSION['user']['idEcole']))
		ajouterCategorie($libelle, $_SESSION['user']['idEcole']);
	
	header('location: ../categorie_depense.php');
	
	echo $_SESSION['user']['idEcole'].' '.$_POST['libelle'];
}


if(isset($_POST['editer']) && isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['id']) && isset($_SESSION['user']))
{
	$libelle=htmlspecialchars($_POST['libelle']);
	$id=(int)$_POST['id'];
	
	if(!isCategorieExiste($libelle, $_SESSION['user']['idEcole']))
		editerCategorie($libelle, $_SESSION['user']['idEcole'], $id);

	header('location: ../categorie_depense.php');
}