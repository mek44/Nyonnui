<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getAbsences($idClasse, $idEnfant, $annee){
    global $base;
    $prepare=$base->prepare("SELECT c.id_eleve, DATE_FORMAT(c.date,'d/m/y') AS dateAbsence, c.periode, c.present, c.motif, "
            ."e.nom, e.prenom FROM controle AS c LEFT JOIN eleve AS e on e.id=c.id_eleve "
            ."WHERE c.id_eleve=:idEnfant AND c.annee=:annee AND c.idClasse=:idClasse ORDER BY c.debut;");
    $prepare->execute([
        'idEnfant'=>$idEnfant,
        'annee'=>$annee,
        'idClasse'=>$idClasse
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

function afficheAbsences($idClasse, $annee, $idEnfant){
    $listeAbsences=getAbsences($idEnfant,$annee,$idClasse);
    $affiche="<table class='table table-bordered table-striped table-condensed'>";
    $affiche.="<tr>".
            "<th>Date</th>"
            ."<th>Periode</th>"
            ."<th>Motif</th>"
            ."<tr>";
    foreach($listeAbsences as $absence){
    $affiche.="<tr>".
            "<td>".$absence['dateAbsence']."</td>"
            ."<td>".$absence['periode']."</td>"
            ."<td>".$absence['motif']."</td>"
            ."<tr>";
    }
    $affiche.="</table>";
    return $affiche;
}

