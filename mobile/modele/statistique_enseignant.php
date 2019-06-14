<?php
function getAbsent($date, $idEcole)
{
    global $base;
    
    $prepare=$base->prepare("SELECT p.nom, p.prenom, DATE_FORMAT(c.debut, '%H:%i') AS debut, DATE_FORMAT(c.fin, '%H:%i') AS fin, c.motif FROM personnel AS p INNER JOIN controle_enseignant AS c 
                    ON p.id=c.id_enseignant WHERE c.present=0 AND c.date=:date AND p.id_ecole=:id_ecole");
    $prepare->execute([
        'date'=>$date,
        'id_ecole'=>$idEcole
    ]);	
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getStatistique($idEcole, $fonction, $prefecture, $jour, $mois, $annee, $anneeScolaire)
{
    global $base;

    $numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));
    $date=$annee.'-'.$mois.'-'.$jour;

    $resultat=[];

    //recuperation de l'effectif total
    
    if($fonction=='Super Administrateur' || $fonction=='Partenaire' || $fonction=='Responsable Régionale' || $fonction=='DPE / DCE')
    {
        $prepare=$base->prepare('SELECT COUNT(em.id_professeur) AS effectif, ec.id, ec.nom FROM emploie AS em INNER JOIN personnel AS p 
                ON p.id=em.id_professeur INNER JOIN ecole AS ec ON ec.id=p.id_ecole INNER JOIN prefecture AS pr ON pr.id=ec.id_prefecture
                WHERE em.jour=:jour AND em.annee=:annee AND pr.id=:id_prefecture GROUP BY ec.id ORDER BY ec.nom');
        $prepare->execute([
                    'jour'=>$numeroJour,
                    'annee'=>$anneeScolaire,
                    'id_prefecture'=>$prefecture
                ]);
        $resultat=$prepare->fetchAll();
        $prepare->closeCursor();
    }
    else if($fonction=='Directeur général' || $fonction=='Directeur' || $fonction=='Proviseur' || $fonction=='Principal')
    {
        $prepare=$base->prepare('SELECT COUNT(em.id_professeur) AS effectif, ec.id, ec.nom FROM emploie AS em INNER JOIN personnel AS p 
                ON p.id=em.id_professeur INNER JOIN ecole AS ec ON ec.id=p.id_ecole WHERE jour=:jour AND annee=:annee AND ec.id=:id_ecole GROUP BY ec.id');
        $prepare->execute([
                    'jour'=>$numeroJour,
                    'annee'=>$anneeScolaire,
                    'id_ecole'=>$idEcole
                ]);
        $resultat=$prepare->fetchAll();
        $prepare->closeCursor();
    }

    //recuperation de l'effectif en fontion du sexe des filles
    $prepare=$base->prepare("SELECT COUNT(id_professeur) AS effectif FROM emploie WHERE jour=:jour AND annee=:annee AND 
            id_professeur IN(SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='F')");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                        'jour'=>$numeroJour,
                        'annee'=>$anneeScolaire,
                        'id_ecole'=>$resultat[$i]['id'],
                ]);

        if($donnee=$prepare->fetch())
        {
            $resultat[$i]['fille']=$donnee['effectif'];
        }
    }
    $prepare->closeCursor();

    //recuperation de l'effectif en fontion du sexe
    $prepare=$base->prepare("SELECT COUNT(id_professeur) AS effectif FROM emploie WHERE jour=:jour AND annee=:annee AND 
            id_professeur IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='M')");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                'jour'=>$numeroJour,
                'annee'=>$anneeScolaire,
                'id_ecole'=>$resultat[$i]['id'],
            ]);

        if($donnee=$prepare->fetch())
        {
            $resultat[$i]['garcon']=$donnee['effectif'];
        }
    }
    $prepare->closeCursor();

    //recuperation du nombre de present
    $prepare=$base->prepare('SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
            WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole)');
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'date'=>$date,
                    'id_ecole'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['present']=$donnee['present'];
        }
    }
    $prepare->closeCursor();

    //recuperation du nombre de fille présent
    $prepare=$base->prepare("SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
            WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='F')");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'date'=>$date,
                    'id_ecole'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['fille_present']=$donnee['present'];
        }
    }
    $prepare->closeCursor();

    //recuperation du nombre de garçon présent
    $prepare=$base->prepare("SELECT COUNT(id_enseignant) AS present FROM controle_enseignant
            WHERE present=1 AND date=:date AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole AND sexe='M')");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'date'=>$date,
                    'id_ecole'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['garcon_present']=$donnee['present'];
        }
    }
    $prepare->closeCursor();

    return $resultat;
}

function getRegion()
{
    global $base;

    $requete=$base->query('SELECT id, nom FROM region ORDER BY nom');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();
    return $resultat;
}


function getPrefecture($idRegion)
{
    global $base;

    $prepare=$base->prepare('SELECT id, nom FROM prefecture WHERE id_region=? ORDER BY nom');
    $prepare->execute([$idRegion]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    return $resultat;
}

