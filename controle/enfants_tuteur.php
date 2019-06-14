<?php

$pageValide=false;

if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']=='Parent')
{
    $pageValide=true;
    include_once ('modele/connexion_base.php');
    include_once('modele/enfants_tuteur.php');
    include_once ('fonction.php');
    $listeEnfants=getEnfants($_SESSION['user']['id']);
}

include_once('vue/enfants_tuteur.php');