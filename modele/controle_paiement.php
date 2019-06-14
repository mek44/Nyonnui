<?php
function getControle($classe, $idEcole, $annee)
{
    global $base;

    $prepare=$base->prepare("SELECT e.id, e.nom, e.prenom, e.matricule FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve"
            . " WHERE e.id_ecole=:ecole AND ce.annee=:annee AND ce.id_classe=:classe ORDER BY nom, prenom");

    $prepare->execute([
        'ecole'=>$idEcole,
        'classe'=>$classe,
        'annee'=>$annee
    ]);

    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    $listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];
    $prepare=$base->prepare('SELECT montant FROM scolarite WHERE mois=:mois AND id_eleve=:eleve AND annee=:annee');
    for($i=0; $i<count($resultat); $i++)
    {
        foreach($listeMois as $mois)
        {
            $prepare->execute([
                'mois'=>$mois,
                'annee'=>$annee,
                'eleve'=>$resultat[$i]['id']
            ]);

            $payer=0;
            if(($reponse=$prepare->fetch()))
            {
                $payer=$reponse['montant'];
            }
            $prepare->closeCursor();

            $resultat[$i]['mois'.$mois]=$payer;
        }
    }

    return $resultat;
}


function getListeClasse($idEcole)
{
    global $base;

    $prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}



if(isset($_GET['classe']))
{
    session_start();
    include_once('connexion_base.php');
    include_once ('../fonction.php');
    $classe=(int)$_GET['classe'];

    $listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];

    $controles=getControle($classe, $_SESSION['user']['idEcole'], $_SESSION['annee']);

    $display='<table class="table table-bordered table-striped table-condensed">
            <tr class="entete-table">
                <th>Matricule</th>
                <th>Prénoms</th>
                <th>Nom</th>
                <th>Sept</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Déc</th>
                <th>Jan</th>
                <th>Fév</th>
                <th>Mar</th>
                <th>Avr</th>
                <th>Mai</th>
            </tr>';

    foreach($controles as $controle)
    {
        $display.='<tr>
            <td>'.$controle['matricule'].'</td>
            <td>'.$controle['prenom'].'</td>
            <td>'.$controle['nom'].'</td>';

            foreach ($listeMois as $mois)
            {
                $display.='<td class="montant">'.formatageMontant($controle['mois'.$mois]).'</td>';
            }

        $display.='</tr>';
    }

    $display.='</table>';

    echo $display;
}