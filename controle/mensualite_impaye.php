<?php
include_once('modele/connexion_base.php');
include_once('modele/mensualite_impaye.php');
include_once ('fonction.php');

$listeClasse=[];
$listeImpayees=[];

$listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général'))
{
    $pageValide=true;
    $listeClasse=getListeClasse($_SESSION['user']['idEcole']);
    $listeImpayees=getListeImpaye(0, 0, $listeMois, $_SESSION['user']['idEcole'], $_SESSION['annee']);
}


include_once('vue/mensualite_impaye.php');
