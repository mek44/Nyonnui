<?php
include_once('modele/connexion_base.php');
include_once('modele/modifier_classe.php');

$observation='';

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];

$listeClasse=getClasse($_SESSION['user']['idEcole']);
$listeMatiere=getMatiere($listeClasse[0]['id'], $_SESSION['user']['idEcole']);
$matiereClasse=getMatiereClasse($listeClasse[0]['id']);
include_once('vue/modifier_classe.php');
