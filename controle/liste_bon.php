<?php
include_once ('modele/connexion_base.php');
include_once ('modele/liste_bon.php');
include_once ('fonction.php');

$pageValide=false;
$bons=[];

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général'))
{
    $pageValide=true;
    $bons=getBons($_SESSION['user']['idEcole']);
}

include_once ('vue/liste_bon.php');

