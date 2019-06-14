<?php
include_once('modele/connexion_base.php');
include_once('modele/etat_journalier_paiement.php');
include_once ('fonction.php');
$pageValide=false;
$etats=[];

$mois=date('m');
$annee=date('Y');
$jour=date('j');

$date=$annee.'-'.$mois.'-'.$jour;

$listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général'))
{
    $pageValide=true;
    $etats=getEtat($date, $_SESSION['user']['idEcole'], $_SESSION['annee']);
}

include_once('vue/etat_journalier_paiement.php');
