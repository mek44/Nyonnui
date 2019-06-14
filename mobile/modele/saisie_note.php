<?php
function getNoteEleve($idClasse, $idMatiere, $mois, $annee)
{
    global $base;

    $prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
            WHERE ce.id_classe=:id_classe AND ce.annee=:annee ORDER BY e.nom, e.prenom');
    $prepare->execute([
                'id_classe'=>$idClasse,
                'annee'=>$annee,
            ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    $prepare=$base->prepare('SELECT valeur FROM note WHERE id_eleve=:id_eleve AND id_matiere=:id_matiere AND mois=:mois AND annee=:annee');
    for($i=0; $i<count($resultat); $i++)
    {
        $note=0;
        $prepare->execute([
                    'id_eleve'=>$resultat[$i]['id'],
                    'id_matiere'=>$idMatiere,
                    'mois'=>$mois,
                    'annee'=>$annee
                ]);
        if($donnee=$prepare->fetch())
            $note=$donnee['valeur'];

        $resultat[$i]['note']=$note;
    }

    return $resultat;
}


function getEleve($classe, $anneeScolaire)
{
    global $base;
    
    $prepare=$base->prepare("SELECT e.id, e.matricule, e.nom, e.prenom, '0' AS note FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee ORDER BY e.nom, e.prenom");
    $prepare->execute([
                'id_classe'=>$classe,
                'annee'=>$anneeScolaire
            ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    return $resultat;
}


function getNote($idEcole, $matricule, $matiere, $mois, $anneeScolaire)
{
    global $base;
    $prepare=$base->prepare('SELECT valeur FROM note WHERE id_eleve=(SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole) AND 
            id_matiere=:id_matiere AND mois=:mois AND annee=:annee');

    $note=0;
    $prepare->execute([
                'matricule'=>$matricule,
                'id_ecole'=>$idEcole,
                'id_matiere'=>$matiere,
                'mois'=>$mois,
                'annee'=>$anneeScolaire
        ]);
    if(($donnee=$prepare->fetch()))
        $note=$donnee['valeur'];

    return str_replace('.', ',', $note);
}


function getClasse($idEcole)
{
    global $base;

    $prepare=$base->prepare('SELECT id, niveau, intitule, option_lycee FROM classe WHERE id_ecole=?');
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getMatiere($idClasse)
{
    global $base;

    $prepare=$base->prepare('SELECT id, nom FROM matiere WHERE id IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=?)');
    $prepare->execute([$idClasse]);
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


function insertNote($idEcole, $matricule, $matiere, $mois, $note, $anneeScolaire)
{
    global $base;
    
    $prepare=$base->prepare('REPLACE INTO note(id_eleve, id_matiere, mois, valeur, annee) VALUES((SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole),
			:id_matiere, :mois, :valeur, :annee)');
    $prepare->execute([
                'matricule'=>$matricule,
                'id_ecole'=>$idEcole,
                'id_matiere'=>$matiere,
                'mois'=>$mois,
                'valeur'=>$note,
                'annee'=>$anneeScolaire
            ]);
}

function getMatiereEnseignant($idEnseignant, $niveau, $idClasse)
{
    global $base;

    $requete='';
    
    if($niveau==='Primaire'){
        $requete='SELECT id, nom FROM matiere WHERE id IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=:id_classe)';
    }else{
        $requete='SELECT m.id, m.nom FROM matiere AS m INNER JOIN classe_matiere_enseignant AS cm ON m.id=cm.id_matiere WHERE cm.id_classe=:id_classe AND cm.id_enseignant=:id_enseignant';
    }
    
    $prepare=$base->prepare($requete);
    $prepare->bindParam('id_classe', $idClasse);
    if($niveau!=='Primaire'){
        $prepare->bindParam('id_enseignant', $idEnseignant);
    }
    $prepare->execute();
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}