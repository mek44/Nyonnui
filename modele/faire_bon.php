<?php
function insertAvance($idPersonnel, $date, $montant, $annee)
{
    global $base;

    $prepare=$base->prepare('INSERT INTO avance(id_personnel, date, montant, annee) VALUES(:id_personnel, :date, :montant, :annee)');
    $prepare->execute([
        'id_personnel'=>$idPersonnel,
        'date'=>$date,                
        'montant'=>$montant,
        'annee'=>$annee
    ]);
}

if(isset($_GET['matricule']))
{
    session_start();
    include_once('connexion_base.php');

    $prepare=$base->prepare('SELECT id, matricule, nom, prenom, photo, telephone FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole');
    $prepare->execute([
        'matricule'=>$_GET['matricule'],
        'id_ecole'=>$_SESSION['user']['idEcole']
    ]);
    $resultat=$prepare->fetch();
    $prepare->closeCursor();

    echo json_encode($resultat);
}

