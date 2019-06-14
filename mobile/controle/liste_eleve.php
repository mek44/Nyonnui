<?php
header('Access-Control-Allow-Origin: *');

function afficherEleve($listeEleve)
{
    $displayEleve='<table class="table table-bordered table-striped table-condensed">
                <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Sexe</th>
                        <th>Date de Naissance</th>
                        <th>Lieu de Naissance</th>
                        <th>Père</th>
                        <th>Mère</th>
                </tr>';
    
    foreach($listeEleve as $eleve)
    {
        $displayEleve.='<tr class="eleve" id="'.$eleve['matricule'].'">
                <td>'.$eleve['matricule'].'</td>
                <td>'.$eleve['nom'].'</td>
                <td>'.$eleve['prenom'].'</td>
                <td>'.$eleve['sexe'].'</td>
                <td>'.$eleve['date_naissance'].'</td>
                <td>'.$eleve['lieu_naissance'].'</td>
                <td>'.$eleve['pere'].'</td>
                <td>'.$eleve['mere'].'</td>
        </tr>';
    }
    
    $displayEleve.='</table>';
    
    return $displayEleve;
}

include_once('../../modele/connexion_base.php');
include_once('../modele/liste_eleve.php');
include_once ('../fonction.php');

if(isset($_GET['idEcole']) && !isset($_GET['afficherTous']) && !isset($_GET['matricule']))
{
    $ecole=(int)$_GET['idEcole'];
    $listeClasse=getListeClasse($ecole);
    $listeAnnee=getListeAnnee($ecole);
    $listeEleve=[];
    if(count($listeClasse)>0 && count($listeAnnee)>0)
    {
        $listeEleve=getListeEleve($listeClasse[0]['id'], $listeAnnee[0]['annee']);
    }
    
    $displayAnnee='';
    $displayClasse='';
    
    foreach($listeAnnee as $annee)
    {
        $displayAnnee.='<option value="'.$annee['annee'].'">'.$annee['annee'].'</option>';
    }
    
    foreach($listeClasse as $classe)
    {
        $displayClasse.='<option value="'.$classe['id'].'">'. formatClasse($classe).'</option>';
    }
    
    $displayEleve=afficherEleve($listeEleve);
    
    $resultat=['annee'=>$displayAnnee, 'classe'=>$displayClasse, 'eleve'=>$displayEleve];
    echo json_encode($resultat);
}



if(isset($_GET['classe']) && isset($_GET['annee']))
{
    $classe=(int)$_GET['classe'];
    $annee=htmlspecialchars($_GET['annee']);

    $listeEleve=getListeEleve($classe, $annee);
    $displayEleve=afficherEleve($listeEleve);
    
    echo $displayEleve;
}

if(isset($_GET['matricule']) && isset($_GET['idEcole']))
{
    $idEcole=(int)$_GET['idEcole'];
    $resultat=rechercheEleve($_GET['matricule'], $idEcole);
    echo json_encode($resultat);
}


if(isset($_GET['afficherTous']) && isset($_GET['idEcole']))
{
    $idEcole=(int)$_GET['idEcole'];
    
    $listeEleve= afficherTous($idEcole);
    $tableEleve='<table class="table table-bordered table-striped table-condensed">
        <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Date de Naissance</th>
                <th>Lieu de Naissance</th>
                <th>Père</th>
                <th>Mère</th>
        </tr>';

    foreach($listeEleve as $eleve)
    {
        $tableEleve.='<tr class="eleve" id="'.$eleve['matricule'].'">
                    <td>'.$eleve['matricule'].'</td>
                    <td>'.$eleve['nom'].'</td>
                    <td>'.$eleve['prenom'].'</td>
                    <td>'.$eleve['sexe'].'</td>
                    <td>'.$eleve['date_naissance'].'</td>
                    <td>'.$eleve['lieu_naissance'].'</td>
                    <td>'.$eleve['pere'].'</td>
                    <td>'.$eleve['mere'].'</td>
            </tr>';
    }
    
    $tableEleve.='</table>';

    echo $tableEleve;
}
