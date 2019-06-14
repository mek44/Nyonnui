<?php

function getBons($idEcole)
{
    global $base;
    
    $prepare=$base->prepare("SELECT p.id, p.nom, p.prenom, p.matricule, p.telephone, a.id AS id_bon, DATE_FORMAT(a.date, '%d-%m-%Y') AS date, a.montant, a.payer FROM personnel AS p INNER JOIN avance AS a "
            . "ON p.id=a.id_personnel WHERE payer<montant AND p.id_ecole=? ORDER BY a.date, p.nom, p.prenom");
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    return $resultat;
}
