<?php
function getListeClasse($idEcole)
{
    global $base;

    $prepare=$base->prepare('SELECT id, niveau, intitule, option_lycee FROM classe WHERE id_ecole=?');
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

function getClasseEnseignant($id, $niveau)
{
    global $base;

    $requete='';
    if($niveau==='Primaire'){
        $requete='SELECT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_enseignant AS ce ON c.id=ce.id_classe WHERE ce.id_enseignant=?';
    }else{
        $requete='SELECT DISTINCT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_matiere_enseignant AS cm ON c.id=cm.id_classe WHERE cm.id_enseignant=?';
    }
        
    $prepare=$base->prepare($requete);
    $prepare->execute([$id]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getPeriode($idClasse, $jour, $annee)
{
    global $base;
    
    $prepare=$base->prepare("SELECT DATE_FORMAT(debut, '%H:%i') AS debut, DATE_FORMAT(fin, '%H:%i') AS fin FROM emploie WHERE id_classe=:classe AND jour=:jour AND annee=:annee");
    $prepare->execute([
        'classe'=>$idClasse,
        'jour'=>$jour,
        'annee'=>$annee
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getListeEleve($idClasse, $annee, $date, $periode)
{
    global $base;

    $prepare=$base->prepare('SELECT e.id, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
            WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
    $prepare->execute([
                'id_classe'=>$idClasse,
                'annee'=>$annee,
            ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    $prepare=$base->prepare('SELECT present, motif FROM controle WHERE id_eleve=:id AND date=:date AND periode=:periode');
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
            'id'=>$resultat[$i]['id'],
            'date'=>$date,
            'periode'=>$periode
        ]);

        if(($donnee=$prepare->fetch()))
        {
            $resultat[$i]['motif']=$donnee['motif'];
            $resultat[$i]['present']=$donnee['present'];
        }
        else
        {
            $resultat[$i]['motif']='';
            $resultat[$i]['present']=1;
        }
    }
    $prepare->closeCursor();

    return $resultat;
}


function controle($id, $date, $periode, $present, $motif, $annee)
{
    global $base;
    
    $prepare=$base->prepare('REPLACE INTO controle(id_eleve, date, periode, present, motif, annee) VALUES(:id_eleve, :date, :periode, :present, :motif, :annee)');
	$prepare->execute([
                'id_eleve'=>$id,
                'date'=>$date,
                'periode'=>$periode,
                'present'=>$present,
                'motif'=>$motif,
                'annee'=>$annee
        ]);
}