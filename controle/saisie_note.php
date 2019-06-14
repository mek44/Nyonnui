<?php
include_once('modele/connexion_base.php');
include_once('modele/saisie_note.php');

if($_SESSION['user']['nom_fonction']!='Enseignant'){
    $listeClasse=getClasse($_SESSION['user']['idEcole']);
    $listeMatiere=getMatiere($listeClasse[0]['id']);
}else{
    $listeClasse= getClasseEnseignant($_SESSION['user']);
    $listeMatiere= getMatiereEnseignant($_SESSION['user'], $listeClasse[0]['id']);
}

$listeEleve=getNoteEleve($listeClasse[0]['id'], $listeMatiere[0]['id'], 1, $_SESSION['annee']);
$listeMois=['Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8, 'Septembre'=>9, 'Octombre'=>10, 'Novembre'=>11, 'Décembre'=>12];

include_once('vue/saisie_note.php');