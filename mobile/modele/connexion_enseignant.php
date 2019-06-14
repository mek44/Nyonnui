<?php
function connexionEnseignant($matricule, $passe, $idEcole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM personnel WHERE matricule=:matricule AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                    'matricule'=>$matricule,
                    'passe'=>$passe,
                    'id_ecole'=>$idEcole
            ]);

    if($resultat=$prepare->fetch())
        $nombre=$resultat['nombre'];

    if($nombre>0){
        return true;
    }else{
        return false;
    }
}

function getInformationEnseignant($matricule, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, nom, 'Enseignant' AS nomFonction, niveau FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole");
    $prepare->execute([
        'matricule'=>$matricule,
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



function getMatiere($idEnseignant, $niveau)
{
    global $base;

    $requete='';
    if($niveau==='Primaire'){
        $requete='SELECT m.id, m.nom, mc.id_classe FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere WHERE mc.id_classe=(SELECT id_classe FROM classe_enseignant WHERE id_enseignant=?)';
    }else{
        $requete='SELECT m.id, m.nom, cm.id_classe FROM matiere AS m INNER JOIN classe_matiere_enseignant AS cm ON m.id=cm.id_matiere WHERE cm.id_enseignant=?';
    }
    $prepare=$base->prepare($requete);
    
    $prepare->execute([$idEnseignant]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getClasseEnseignant($idEnseignant, $niveau)
{
    global $base;

    $requete='';
    if($niveau==='Primaire'){
        $requete='SELECT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_enseignant AS ce ON c.id=ce.id_classe WHERE ce.id_enseignant=?';
    }else{
        $requete='SELECT DISTINCT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_matiere_enseignant AS cm ON c.id=cm.id_classe WHERE cm.id_enseignant=?';
    }
        
    $prepare=$base->prepare($requete);
    $prepare->execute([$idEnseignant]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getEleve($idEnseignant, $niveau, $anneeScolaire)
{
    global $base;
    
    $requete='';
    if($niveau==='Primaire'){
        $requete="SELECT e.id, e.matricule, e.nom, e.prenom, ce.id_classe FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
		WHERE ce.id_classe=(SELECT id_classe FROM classe_enseignant WHERE id_enseignant=:id_enseignant) AND ce.annee=:annee ORDER BY e.nom, e.prenom";
    }else{
        $requete="SELECT e.id, e.matricule, e.nom, e.prenom, ce.id_classe FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve
		WHERE ce.id_classe IN (SELECT id_classe FROM classe_matiere_enseignant WHERE id_enseignant=:id_enseignant) AND ce.annee=:annee ORDER BY e.nom, e.prenom";
    }
    
    $prepare=$base->prepare($requete);
    $prepare->execute([
                'id_enseignant'=>$idEnseignant,
                'annee'=>$anneeScolaire
            ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    return $resultat;
}