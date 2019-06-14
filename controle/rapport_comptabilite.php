<?php
include_once('modele/connexion_base.php');
include_once('modele/rapport_comptabilite.php');
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
    $mensualites=getMensualite($_SESSION['user']['idEcole'], $_SESSION['annee']);
    $depenses=getDepense($_SESSION['user']['idEcole'], $_SESSION['annee']);
    $salaires=getSalaire($_SESSION['user']['idEcole'], $_SESSION['annee']);
    $bons=getBons($_SESSION['user']['idEcole'], $_SESSION['annee']);
}

include_once('vue/rapport_comptabilite.php');
