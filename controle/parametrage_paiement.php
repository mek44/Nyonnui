<?php
include_once('modele/connexion_base.php');
include_once('modele/parametrage_paiement.php');
include_once('fonction.php');

$jour=date('d');
$moisl=date('m');
$annee=date('Y');

$pageValide=false;
$mensualites=[];
$depenses=[];
$salaires=[];
$bons=[];

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général') && isset($_SESSION['annee']))
{
    $pageValide=true;
    $idEcole = $_SESSION['user']['idEcole'];
    $annee = $_SESSION['annee'];
    $niveaux = getLevels($idEcole);
    $scolarites = getScolarites($idEcole,$annee);
}

include_once('vue/parametrage_paiement.php');
