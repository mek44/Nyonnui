<?php
function getEcole($annee, $region=null, $prefecture=null, $cycle)
{
    global $base;

    $resultat=[];

    if($region==null && $prefecture==null)
    {
        $prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
                INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE e.id_cycle=:cycle ORDER BY e.nom');
        $prepare->execute(['region'=>$region]);
        $resultat=$prepare->fetchAll();
    }
    else if($region!=null && $prefecture==null)
    {
        $prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
                INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE r.id=:region AND e.id_cycle=:cycle ORDER BY e.nom');
        $prepare->execute([
                    'region'=>$region,
                    'cycle'=>$cycle
                ]);
        $resultat=$prepare->fetchAll();
    }else if($region==null && $prefecture!=null)
    {
        $prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
                INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE p.id=:prefecture AND e.id_cycle=:cycle ORDER BY e.nom');
        $prepare->execute([
                    'prefecture'=>$prefecture,
                    'cycle'=>$cycle
                ]);
        $resultat=$prepare->fetchAll();
    }
    else 
    {
        $prepare=$base->prepare('SELECT e.id, e.nom, e.adresse, e.telephone, r.nom AS nom_region, p.nom AS nom_pref FROM ecole AS e 
                INNER JOIN prefecture AS p ON p.id=e.id_prefecture INNER JOIN region AS r ON r.id=p.id_region WHERE r.id=:region AND p.id=:prefecture 
                AND e.id_cycle=:cycle ORDER BY e.nom');
        $prepare->execute([
                    'region'=>$region,
                    'prefecture'=>$prefecture,
                    'cycle'=>$cycle
                ]);
        $resultat=$prepare->fetchAll();      
    }

    //effectif total

    $prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN 
            ecole AS e ON e.id=c.id_ecole WHERE e.id=:idEcole AND ce.annee=:annee');
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'idEcole'=>$resultat[$i]['id'],
                    'annee'=>$annee
                ]);
        if(($donnees=$prepare->fetch())){
            $resultat[$i]['effectif']=$donnees['nombre']; 
        }
    }

    //effectif des filles et garçon

    $prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN 
            ecole AS e ON e.id=c.id_ecole INNER JOIN eleve AS el ON el.id=ce.id_eleve WHERE e.id=:idEcole AND ce.annee=:annee AND el.sexe=:sexe');

    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'idEcole'=>$resultat[$i]['id'],
                    'annee'=>$annee,
                    'sexe'=>'F'
                ]);
        if(($donnees=$prepare->fetch())){
            $resultat[$i]['fille']=$donnees['nombre'];
        }
        $prepare->execute([
                    'idEcole'=>$resultat[$i]['id'],
                    'annee'=>$annee,
                    'sexe'=>'M'
                ]);
        if(($donnees=$prepare->fetch())){
            $resultat[$i]['garcon']=$donnees['nombre'];
        }
    }

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


function getCycle()
{
    global $base;

    $requete=$base->query('SELECT libelle, id FROM cycle ORDER BY libelle');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();

    return $resultat;
}


function getStatistique($prefecture, $cycle)
{
    global $base;

    $requete=$base->query('SELECT id, libelle FROM etablissement ORDER BY libelle');
    $etablissement=$requete->fetchAll();
    $requete->closeCursor();

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM ecole WHERE id_prefecture=:id_prefecture AND id_cycle=:id_cycle 
            AND id_etablissement=:etablissement');

    $resultat=[];
    foreach ($etablissement as $etablis) {
        $prepare->execute([
                    'id_prefecture'=>$prefecture,
                    'id_cycle'=>$cycle,
                    'etablissement'=>$etablis['id']
                ]);
        $reponse=$prepare->fetch();
        $prepare->closeCursor();

        array_push($resultat, ['etablissement'=>$etablis['libelle'], 'nombre'=>$reponse['nombre']]);
    }

    return $resultat;
}