<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/resultats.php');
include_once('../fonction.php');

function affichage($resultat, $trimestre)
{
    $table='<table class="table table-bordered table-striped table-condensed">
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>';

    if($trimestre==4)
    {
        $table.='<th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>';
    }
    $table.='<th>Rang</th>
                    <th>Moyenne</th>
                    <th>Observation</th>
                    <th></th>
            </tr>';

    foreach($resultat as $eleve)
    {
        $table.='<tr class="eleve" id="'.$eleve['matricule'].'">
                <td>'.$eleve['matricule'].'</td>
                <td>'.$eleve['nom'].'</td>
                <td>'.$eleve['prenom'].'</td>';

        if($trimestre==4)
        {
            $table.='<td>'.parseReel($eleve['trime1']).'</td>
            <td>'.parseReel($eleve['trime2']).'</td>
            <td>'.parseReel($eleve['trime3']).'</td>';
        }

        $table.='<td>'.$eleve['rang'].'</td>
                <td>'.parseReel($eleve['moyenne']).'</td>
                <td>'.$eleve['observation'].'</td>
                <td><a href="bulletin.html?" class="bulletin" id="'.$eleve['id'].'">bulletin</a></td>
        </tr>';
    }

    $table.='</table>';

    return $table;
}


if(isset($_GET['idEcole']) && !isset($_GET['trimestre']) && !isset($_GET['classe']))
{
    $idEcole=(int)$_GET['idEcole'];
    
    $listeClasse=getListeClasse($idEcole);
    $resultat=[];
    if(count($listeClasse)>0){
	$resultat=getResultatTrimestre($listeClasse[0]['id'], 1, getAnneeScolaire());
    }
    
    $displayClasse='';
    foreach($listeClasse as $classe)
    {
        $displayClasse.='<option value="'.$classe['id'].'">'.formatClasse($classe).'</option>';
    }
    
    $reponse=['classe'=>$displayClasse, 'resultat'=>affichage($resultat, 1)];
    echo json_encode($reponse);
}


if(isset($_GET['classe']) && isset($_GET['trimestre']) && isset($_GET['idEcole']))
{
    $classe=(int)$_GET['classe'];
    $trimestre=(int)$_GET['trimestre'];
    $idEcole=(int)$_GET['idEcole'];
	
    if($trimestre<4){
        $resultat=getResultatTrimestre($classe, $trimestre, $_COOKIE['annee']);
    }else{
        $resultat=getResultatAnnuel($classe, $_COOKIE['annee']);
    }
    
    echo affichage($resultat, $trimestre);
}