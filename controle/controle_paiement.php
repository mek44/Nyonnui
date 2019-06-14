<?php
include_once('modele/connexion_base.php');
include_once('modele/controle_paiement.php');
include_once ('fonction.php');
$pageValide=false;
$controles=[];
$listeClasse=[];
$listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];
//$listeMois=['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mars', 'Avril', 'Mai'];

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général'))
{
    $pageValide=true;
    $listeClasse= getListeClasse($_SESSION['user']['idEcole']);
    if(count($listeClasse)>0){
        $controles=getControle($listeClasse[0]['id'], $_SESSION['user']['idEcole'], $_SESSION['annee']);
    }
}

include_once('vue/controle_paiement.php');
