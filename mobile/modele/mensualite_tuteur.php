<?php

function getInfoEleve($idEleve, $annee)
{
    global $base;

    $prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom, e.sexe, e.photo, c.niveau, c.intitule, c.option_lycee
            FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe 
            WHERE e.id=:id AND ce.annee=:annee');
    $prepare->execute([
                'id'=>$idEleve,
                'annee'=>$annee
            ]);
    $resultat=$prepare->fetch();
    $prepare->closeCursor();
    return $resultat;
}


function getVersements($idEleve, $annee)
{
    global $base;
    
    $prepare=$base->prepare('SELECT DATE_FORMAT(date, \'%d-%m-%Y\') AS date_paie, mois, montant, reduction, num_recus FROM scolarite
			WHERE id_eleve=:id AND annee=:annee ORDER BY date');
    $prepare->execute([
            'id'=>$idEleve,
            'annee'=>$annee
        ]);

    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}