<?php
function connexionEleve($matricule, $passe, $idEcole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM eleve WHERE matricule=:matricule AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                'matricule'=>$matricule,
                'passe'=>$passe,
                'id_ecole'=>$idEcole
            ]);

    if(($resultat=$prepare->fetch())){
        $nombre=$resultat['nombre'];
    }
    
    if($nombre>0){
        return true;
    }else{
        return false;
    }
}



function connexionParent($telephone, $passe, $idEcole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM tuteur WHERE telephone=:telephone AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                'telephone'=>$telephone,
                'passe'=>$passe,
                'id_ecole'=>$idEcole
            ]);

    if(($resultat=$prepare->fetch())){
        $nombre=$resultat['nombre'];
    }
    
    if($nombre>0){
        return true;
    }else{
        return false;
    }
}


function getInformationEleve($matricule, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, CONCAT_WS(' ',nom, prenom) AS nom, 'Eleve' AS nomFonction FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole");
    $prepare->execute([
        'matricule'=>$matricule,
        'id_ecole'=>$idEcole
    ]);
    
    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}


function getInformationParent($telephone, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, nom, 'Parent' AS nomFonction FROM tuteur WHERE telephone=:telephone AND id_ecole=:id_ecole");
    $prepare->execute([
        'telephone'=>$telephone,
        'id_ecole'=>$idEcole
    ]);
    
    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}


function getEcole()
{
    global $base;

    $requete=$base->query('SELECT id, nom FROM ecole ORDER BY nom');
    $resultat=$requete->fetchAll();
    $requete->closeCursor();
    return $resultat;
}