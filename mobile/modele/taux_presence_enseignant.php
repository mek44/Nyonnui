<?php
function getTauxPresence($idEcole, $listeMois, $moisActuel, $annee)
{
    global $base;

    $listeTaux=[];

    $preparePresencePossible=$base->prepare('SELECT COUNT(*) AS presence_possible FROM controle_enseignant WHERE annee=:annee AND MONTH(date)=:mois 
            AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole)');


    $preparePresenceEffective=$base->prepare('SELECT COUNT(*) AS presence_effective FROM controle_enseignant WHERE annee=:annee AND MONTH(date)=:mois AND present=1 
            AND id_enseignant IN (SELECT id FROM personnel WHERE id_ecole=:id_ecole)');
    foreach($listeMois as $nom=>$valeur)
    {
        $taux['mois']=$nom;

        $preparePresencePossible->execute([
                    'annee'=>$annee,
                    'mois'=>$valeur,
                    'id_ecole'=>$idEcole
                ]);
        $presencePossible=0;
        if($donnees=$preparePresencePossible->fetch())
                $presencePossible=$donnees['presence_possible'];

        $presenceEffective=0;
        $preparePresenceEffective->execute([
                    'annee'=>$annee,
                    'mois'=>$valeur,
                    'id_ecole'=>$idEcole
                ]);
        $nombre=0;
        if($donnees=$preparePresenceEffective->fetch())
            $presenceEffective=$donnees['presence_effective'];

        $taux['taux_presence']=$presencePossible==0?0:($presenceEffective*100)/$presencePossible;

        array_push($listeTaux, $taux);

        if($valeur==$moisActuel)
            break;
    }

    return $listeTaux;
}

function getNomEcole($idEcole)
{
    global $base;

    $nom='';

    $prepare=$base->prepare('SELECT nom FROM ecole WHERE id=?');
    $prepare->execute([$idEcole]);
    if($donnees=$prepare->fetch())
        $nom=$donnees['nom'];
    $prepare->closeCursor();

    return $nom;
}