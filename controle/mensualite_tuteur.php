<?php

$pageValide=false;
$listeMois=['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
$total=0;

if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']=='Parent' && isset($_GET['id']))
{
    $pageValide=true;
    $idEleve=(int)$_GET['id'];
    
    include_once ('modele/connexion_base.php');
    include_once('modele/mensualite_tuteur.php');
    include_once ('fonction.php');
    $infos= getInfoEleve($idEleve);
    $listeVersement= getVersements($idEleve);
}

include_once('vue/mensualite_tuteur.php');

