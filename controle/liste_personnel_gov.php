<?php
$pageValide=false;
$listePersonnel=[];

if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']==='DRH')
{
    $pageValide=true;
    include_once('modele/connexion_base.php');
    include_once('modele/liste_personnel_gov.php');
    $listePrefecture= getPrefecture($_SESSION['user']['id_region']);
    $listeCategorie=getCategories();
    
    $listePersonnel=[];
    $statistiques=[];
    $statistiquesGlobale=[];
    
    if(count($listePrefecture)>0 && count($listeCategorie)>0)
    {
        $listePersonnel=getPersonnel($listePrefecture[0]['id'], $listeCategorie[0]['categorie']); 
        $statistiques=getStatistique($listePrefecture[0]['id']);
        $statistiquesGlobale=statistiqueGlobale($_SESSION['user']['id_region']);
    }
}

include_once('vue/liste_personnel_gov.php');
