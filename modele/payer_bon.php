<?php
function payerBon($idBon, $verser)
{
    global $base;

    $prepare=$base->prepare('UPDATE avance SET payer=payer+:verser WHERE id=:id');
    $prepare->execute([
        'id'=>$idBon,              
        'verser'=>$verser,
    ]);
}


function getInfo($idBon)
{
    global $base;
    $prepare=$base->prepare('SELECT p.id, p.matricule, p.nom, p.prenom, p.photo, p.telephone, a.montant, a.payer FROM personnel AS p INNER JOIN avance AS a ON p.id=a.id_personnel WHERE a.id=?');
    $prepare->execute([$idBon]);
    $resultat=$prepare->fetch();
    $prepare->closeCursor();

    return $resultat;
}

