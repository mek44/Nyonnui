<?php

function getEnfants($idTuteur, $annee)
{
    global $base;
    
    $prepare=$base->prepare('SELECT e.id, e.nom, e.prenom, e.matricule, c.niveau, c.intitule, c.option_lycee FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve '
            . 'INNER JOIN classe AS c ON c.id=ce.id_classe WHERE e.id_tuteur=:tuteur AND ce.annee=:annee');
    $prepare->execute([
        'tuteur'=>$idTuteur,
        'annee'=>$annee
        ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

