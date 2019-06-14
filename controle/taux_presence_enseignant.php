<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']) && isset($_GET['id_ecole']))
{
    $pageValide=true;
    
    include_once('modele/connexion_base.php');
    include_once('modele/taux_presence_enseignant.php');
    include_once('fonction.php');

    $idEcole=(int)$_GET['id_ecole'];
    $listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
    $moisActuel=date('m');

    $ecole=getNomEcole($idEcole);
    $listeTaux=getTauxPresence($idEcole, $listeMois, $moisActuel, $_SESSION['annee']);
	
}

include_once('vue/taux_presence_enseignant.php');