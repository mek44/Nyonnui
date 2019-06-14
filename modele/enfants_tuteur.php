<?php

function getEnfants($idTuteur)
{
    global $base;
    
    $prepare=$base->prepare('SELECT e.id, e.nom, e.prenom, e.matricule, n.libelle AS niveau, c.intitule, c.option_lycee, ce.id_classe as idClasse FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve '
            . 'INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN niveau as n ON c.niveau=n.niveau WHERE e.id_tuteur=:tuteur AND ce.annee=:annee');
    $prepare->execute([
        'tuteur'=>$idTuteur,
        'annee'=>$_SESSION['annee']
        ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

