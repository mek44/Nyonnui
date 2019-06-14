<?php

function getMensualite($idEcole, $annee)
{
    global $base;
    
    $prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=:id_ecole ORDER BY niveau');
    $prepare->execute([
        'id_ecole'=>$idEcole
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    $prepare=$base->prepare("SELECT SUM(s.montant) AS montant, SUM(s.reduction) AS reduction FROM scolarite AS s INNER JOIN eleve AS e ON e.id=s.id_eleve "
            . "INNER JOIN classe_eleve AS c ON e.id=c.id_eleve WHERE e.id_ecole=:ecole AND c.id_classe=:classe AND c.annee=:annee_classe AND s.annee=:annee_scolarite");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
            'ecole'=>$idEcole,
            'classe'=>$resultat[$i]['id'],
            'annee_classe'=>$annee,
            'annee_scolarite'=>$annee
        ]);
        $montant=0;
        $reduction=0;
        
        if(($donnees=$prepare->fetch()))
        {
            $montant=$donnees['montant'];
            $reduction=$donnees['reduction'];
        }
        
        $resultat[$i]['montant']=$montant;
        $resultat[$i]['reduction']=$reduction;
    }
    
    return $resultat;
}


function getDepense($idEcole, $annee)
{
    global $base;
	
    $prepare=$base->prepare('SELECT id, libelle FROM categorie_depense WHERE id_ecole=?');
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    
    $prepare=$base->prepare("SELECT SUM(montant) AS montant FROM depense WHERE id_ecole=:id_ecole AND id_depense=:categorie AND annee=:annee");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
            'id_ecole'=>$idEcole,
            'categorie'=>$resultat[$i]['id'],
            'annee'=>$annee
        ]);
        
        $montant=0;
        
        if(($donnees=$prepare->fetch()))
        {
            $montant=$donnees['montant'];
        }
        
        $resultat[$i]['montant']=$montant;
    }
    
    return $resultat;
}
  


function getSalaire($idEcole, $annee)
{
    global $base;
    
    $prepare=$base->prepare("SELECT id, matricule, nom, prenom FROM personnel WHERE id_ecole=:id_ecole");
    $prepare->execute(['id_ecole'=>$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    
    $prepare=$base->prepare("SELECT SUM(salaire_base) AS sal_base, SUM(volume_horaire) AS volume, SUM(taux_horaire) AS taux, SUM(volume_horaire*taux_horaire) AS prestation
        FROM salaire WHERE id_personnel=:personnel AND annee=:annee");
    
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
            'personnel'=>$resultat[$i]['id'],
            'annee'=>$annee
        ]);
        
        $salBase=0;
        $volume=0;
        $taux=0;
        $prestation=0;
        
        if(($donnees=$prepare->fetch()))
        {
            $salBase=$donnees['sal_base'];
            $volume=$donnees['volume'];
            $taux=$donnees['taux'];
            $prestation=$donnees['prestation'];
        }
        
        $resultat[$i]['sal_base']=$salBase;
        $resultat[$i]['volume']=$volume;
        $resultat[$i]['taux']=$taux;
        $resultat[$i]['prestation']=$prestation;
    }
    

    return $resultat;
}
    



function getBons($idEcole, $annee)
{
    global $base;
    
    $prepare=$base->prepare("SELECT p.id, p.nom, p.prenom, p.matricule, a.montant, a.payer FROM personnel AS p INNER JOIN avance AS a "
            . "ON p.id=a.id_personnel WHERE p.id_ecole=:ecole AND annee=:annee GROUP BY a.id_personnel ORDER BY p.nom, p.prenom");
    $prepare->execute([
        'ecole'=>$idEcole,
        'annee'=>$annee
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    return $resultat;
}