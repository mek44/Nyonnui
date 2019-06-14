<?php
function isEcoleExiste($ecole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM ecole WHERE nom=:nom');
    $prepare->execute([
            'nom'=>$ecole,
        ]);

    if($resultat=$prepare->fetch()){
        $nombre=$resultat['nombre'];
    }
    
    if($nombre>0){
        return true;
    }else{
        false;
    }
}


function insertEcole($idPrefecture, $nom, $adresse, $telephone, $etablissement, $cycle, $cfip, $partOng, $partEcole)
{
    global $base;

    $prepare=$base->prepare('INSERT INTO ecole(id_prefecture, nom, adresse, telephone, id_etablissement, id_cycle, cfip, part_ong, part_ecole) 
            VALUES(:id_prefecture, :nom, :adresse, :telephone, :id_etablissement, :id_cycle, :cfip, :part_ong, :part_ecole)');
    $prepare->execute([
        'id_prefecture'=>$idPrefecture,
        'nom'=>$nom,
        'adresse'=>$adresse,
        'telephone'=>$telephone,
        'id_etablissement'=>$etablissement,
        'id_cycle'=>$cycle,
        'cfip'=>$cfip,
        'part_ong'=>$partOng,
        'part_ecole'=>$partEcole
    ]);
}


function getRegion()
{
    global $base;

    $requete=$base->query('SELECT nom, id FROM region ORDER BY nom');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();

    return $resultat;
}

function getEtablissement()
{
    global $base;

    $requete=$base->query('SELECT libelle, id FROM etablissement ORDER BY libelle');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();

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


function getPrefecture($idRegion)
{
    global $base;

    $prepare=$base->prepare('SELECT id, nom FROM prefecture WHERE id_region=? ORDER BY nom');
    $prepare->execute([$idRegion]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    return $resultat;
}

if(isset($_GET['region']))
{
    include_once('connexion_base.php');
    $idRegion=(int)$_GET['region'];

    $listePrefecture=getPrefecture($idRegion);
    $option='';
    foreach($listePrefecture as $prefecture)
    {
        $option.='<option value="'.$prefecture['id'].'">'.$prefecture['nom'].'</option>';
    }

    echo $option;
}