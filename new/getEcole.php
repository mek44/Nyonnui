<?php
function getEcole()
{
    global $db;

    $requete=$db->query('SELECT id, nom FROM ecole ORDER BY nom');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();
    return $resultat;
}
