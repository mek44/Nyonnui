<?php
include_once('modele/connexion_base.php');
include_once('modele/mensualite_eleve.php');

$pageValide=false;
if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général'))
{
    $pageValide=true;
}

include_once('vue/mensualite_eleve.php');
