<?php
include_once('modele/connexion_base.php');
include_once('modele/liste_depense.php');

$mois=date('m');
$annee=date('Y');
$jour=date('j');

$debut=$annee.'-'.$mois.'-1';
$fin=$annee.'-'.$mois.'-'.$jour;

$listeCategorie=getCategorie($_SESSION['user']['idEcole']);
$listeDepense=getListeDepense($debut, $fin, 0, $_SESSION['user']['idEcole']);

include_once('vue/liste_depense.php');
