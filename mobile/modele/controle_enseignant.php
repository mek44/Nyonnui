<?php
function getControle($idEcole, $jour, $mois, $annee)
{
    global $base;
    $numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));
    $date=$annee.'-'.$mois.'-'.$jour;

    $prepare=$base->prepare("SELECT p.id, p.nom, p.prenom, m.nom AS nom_matiere, m.id AS id_matiere, c.id AS id_classe,
            c.niveau, c.intitule, c.option_lycee, DATE_FORMAT(e.debut, '%H:%i') AS debut,
            DATE_FORMAT(e.fin, '%H:%i') AS fin FROM personnel AS p INNER JOIN emploie AS e ON p.id=e.id_professeur 
            INNER JOIN matiere AS m ON m.id=e.id_matiere INNER JOIN classe AS c ON c.id=e.id_classe WHERE e.jour=:jour AND p.id_ecole=:id_ecole");
    $prepare->execute([
            'jour'=>$numeroJour,
            'id_ecole'=>$idEcole
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    $prepare=$base->prepare('SELECT present, motif FROM controle_enseignant WHERE id_enseignant=:id AND date=:date AND debut=:debut AND fin=:fin');
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
                'id'=>$resultat[$i]['id'],
                'date'=>$date,
                'debut'=>$resultat[$i]['debut'],
                'fin'=>$resultat[$i]['fin']
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


function enregistrementControle($idEnseignant, $date, $idMatiere, $idClasse, $debut, $fin, $present, $motif, $annee)
{
    global $base;
    
    $prepare=$base->prepare('REPLACE INTO controle_enseignant(id_enseignant, date, id_matiere, id_classe, debut, fin, present, motif, annee) 
            VALUES(:id_enseignant, :date, :id_matiere, :id_classe, :debut, :fin, :present, :motif, :annee)');
    $prepare->execute([
            'id_enseignant'=>$idEnseignant,
            'date'=>$date,
            'id_matiere'=>$idMatiere,
            'id_classe'=>$idClasse,
            'debut'=>$debut,
            'fin'=>$fin,
            'present'=>$present,
            'motif'=>$motif,
            'annee'=>$annee
        ]);
}