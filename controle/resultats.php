<?php
include_once('modele/connexion_base.php');
include_once('modele/resultats.php');
include_once('fonction.php');

$listeClasse=getListeClasse($_SESSION['user']['idEcole']);
$resultat=[];
if(count($listeClasse)>0)
	$resultat=getResultatTrimestre($listeClasse[0]['id'], 1);
include_once('vue/resultats.php');