<?php
function getStatistique($idEcole, $annee, $date)
{
    global $base;

    //recuperation de la classe et l'effectif total
    $prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS effectif, c.id, c.niveau, c.intitule, c.option_lycee FROM classe_eleve AS ce 
            INNER JOIN classe AS c ON c.id=ce.id_classe WHERE ce.annee=:annee AND c.id_ecole=:id_ecole GROUP BY ce.id_classe');
    $prepare->execute([
                    'annee'=>$annee,
                    'id_ecole'=>$idEcole
            ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    //recuperation de l'effectif en fontion du sexe
    $prepare=$base->prepare("SELECT COUNT(ce.id_eleve) AS nombre FROM classe_eleve AS ce 
            INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN eleve AS e ON e.id=ce.id_eleve 
            WHERE ce.annee=:annee AND c.id_ecole=:id_ecole_classe AND e.id_ecole=:id_ecole_eleve AND e.sexe=:sexe AND ce.id_classe=:id_classe");

    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'annee'=>$annee,
                    'id_ecole_classe'=>$idEcole,
                    'id_ecole_eleve'=>$idEcole,
                    'sexe'=>'F',
                    'id_classe'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['fille']=$donnee['nombre'];
        }

        $prepare->execute([
                    'annee'=>$annee,
                    'id_ecole_classe'=>$idEcole,
                    'id_ecole_eleve'=>$idEcole,
                    'sexe'=>'M',
                    'id_classe'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['garcon']=$donnee['nombre'];
        }
    }
    $prepare->closeCursor();

    //recuperation du nombre d'absent
    $prepare=$base->prepare('SELECT COUNT(id_eleve) AS absent FROM controle
            WHERE present=0 AND date=:date AND id_eleve IN (SELECT id_eleve FROM classe_eleve WHERE id_classe=:id_classe AND annee=:annee)');
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'date'=>$date,
                    'annee'=>$annee,
                    'id_classe'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['absent']=$donnee['absent'];
        }
    }
    $prepare->closeCursor();

    //recuperation du nombre de fille absent 
    $prepare=$base->prepare("SELECT COUNT(id_eleve) AS absent FROM controle 
            WHERE present=0 AND date=:date AND id_eleve IN (SELECT ce.id_eleve FROM classe_eleve AS ce INNER JOIN eleve AS e ON e.id=ce.id_eleve
            WHERE ce.id_classe=:id_classe AND ce.annee=:annee AND e.sexe='F')");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                    'date'=>$date,
                    'annee'=>$annee,
                    'id_classe'=>$resultat[$i]['id']
                ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['fille_absent']=$donnee['absent'];
        }
    }
    $prepare->closeCursor();

    return $resultat;
}


function getClasseEnseignant($id, $niveau)
{
    global $base;

    $resultat=[];
    
    $requete='';
    if($niveau==='Primaire'){
        $requete='SELECT c.id FROM classe AS c INNER JOIN classe_enseignant AS ce ON c.id=ce.id_classe WHERE ce.id_enseignant=?';
    }else{
        $requete='SELECT DISTINCT c.id FROM classe AS c INNER JOIN classe_matiere_enseignant AS cm ON c.id=cm.id_classe WHERE cm.id_enseignant=?';
    }
        
    $prepare=$base->prepare($requete);
    $prepare->execute([$id]);
    while(($donnees=$prepare->fetch())){
        array_push($resultat, $donnees['id']);
    }
    $prepare->closeCursor();
    return $resultat;
}


function getEcole($idEcole)
{
    global $base;

    $nom='';

    $prepare=$base->prepare('SELECT nom FROM ecole WHERE id=?');
    $prepare->execute([$idEcole]);
    if(($resultat=$prepare->fetch()))
        $nom=$resultat['nom'];

    $prepare->closeCursor();

    return $nom;
}


function getAbsent($date, $annee, $idClasse)
{
    global $base;
    
    $prepare=$base->prepare('SELECT e.nom, e.prenom, c.motif FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
				INNER JOIN controle AS c ON e.id=c.id_eleve WHERE c.present=0 AND c.date=:date AND ce.id_classe=:id_classe AND ce.annee=:annee');
    $prepare->execute([
            'date'=>$date,
            'annee'=>$annee,
            'id_classe'=>$idClasse
    ]);	
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

