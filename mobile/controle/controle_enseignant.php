<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/controle_enseignant.php');
include_once('../fonction.php');

function afficherControle($listeControle)
{
    $table='<table class="table table-condensed table-bordered">
                <tr>
                    <th style="width: 25%">Enseignant</th>
                    <th style="width: 10%">Classe</th>
                    <th style="width: 15%">Matière</th>
                    <th style="width: 5%">Début</th>
                    <th style="width: 5%">Fin</th>
                    <th style="width: 5%">Présent</th>
                    <th style="width: 30%">Motif</th>
                </tr>';

								
    foreach ($listeControle as $controle)
    {
        $checked='';
        if($controle['present']==1)
                $checked='checked';

        $table.='<tr class="enseignant" id="'.$controle['id'].'">
                <td>'.$controle['nom'].' '.$controle['prenom'].'</td>
                <td id="'.$controle['id_classe'].'">'.formatClasse($controle).'</td>
                <td id="'.$controle['id_matiere'].'">'.$controle['nom_matiere'].'</td>
                <td>'.$controle['debut'].'</td>
                <td>'.$controle['fin'].'</td>
                <td><input type="checkbox" '.$checked.' /></td>
                <td><input type="text" name="motif" class="form-controle" style="width: 100%" value="'.$controle['motif'].'" /></td>
        </tr>';
    }

    $table.='</table>';
    
    return $table;
}


if(isset($_GET['idEcole']) && !isset($_GET['jour']) && !isset($_GET['mois']) && !isset($_GET['annee']))
{
    $mois=date('m');
    $annee=date('Y');
    $jour=date('d');
    $idEcole=(int)$_GET['idEcole'];
	
    $listeControle=getControle($idEcole, $jour, $mois, $annee);
    
    echo afficherControle($listeControle);
}


if(isset($_POST['idEnseignant']) && isset($_POST['motif']) && isset($_POST['jour']) && isset($_POST['mois']) && isset($_POST['annee']) && isset($_POST['present']) &&
	isset($_POST['classe']) && isset($_POST['matiere']) && isset($_POST['debut']) && isset($_POST['fin']))
{	
    $date=$_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
    $debut=$_POST['debut'];
    $fin=$_POST['fin'];
    $present=(int)$_POST['present'];
    $idClasse=(int)$_POST['classe'];
    $idMatiere=(int)$_POST['fin'];
    $idEnseignant=(int)$_POST['idEnseignant'];

    enregistrementControle($idEnseignant, $date, $idMatiere, $idClasse, $debut, $fin, $present, $_POST['motif'], getAnneeScolaire());
}



if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['idEcole']))
{
    $annee=(int)$_GET['annee'];
    $mois=(int)$_GET['mois'];
    $jour=(int)$_GET['jour'];
    $idEcole=(int)$_GET['idEcole'];

    if(!checkdate($mois, $jour, $annee))
    {
        $mois=date('m');
        $annee=date('Y');
        $jour=date('d');
    }

    $listeControle=getControle($idEcole, $jour, $mois, $annee);

    echo afficherControle($listeControle);
}