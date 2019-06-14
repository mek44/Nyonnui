<?php
include_once('modele/connexion_base.php');
include_once('modele/categorie_depense.php');

$listeCategories=[];
if(isset($_SESSION['user']))
	$listeCategories=getCategorie($_SESSION['user']['idEcole']);
include_once('vue/categorie_depense.php');
