<?php
include_once('modele/connexion_base.php');
include_once('modele/liste_eleve.php');

$listeClasse=getListeClasse($_SESSION['user']['idEcole']);
$listeAnnee=getListeAnnee($_SESSION['user']['idEcole']);
$listeEleve=[];
if(count($listeClasse)>0 && count($listeAnnee)>0)
{
	$listeEleve=getListeEleve($listeClasse[0]['id'], $listeAnnee[0]['annee']);
}

include_once('vue/liste_eleve.php');
