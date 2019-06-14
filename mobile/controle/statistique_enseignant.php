<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/statistique_enseignant.php'); 
include_once ('../fonction.php');

function afficherStatistique($statistique)
{
    $code='';
    
    foreach($statistique as $ecole)
    {
        $code.='<div class="col-lg-3 col-xs-12 col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h1 class="panel-title">'.$ecole['nom'].'</h1>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Effectif: <span class="badge succes">'.$ecole['effectif'].'</span></li>
                            <li class="list-group-item">Garçons: <span class="badge succes">'.($ecole['garcon']).'</span></li>
                            <li class="list-group-item">Filles: <span class="badge succes">'.$ecole['fille'].'</span></li>
                        </ul>

                        <ul class="list-group">
                            <li class="list-group-item">Présent(s): <span class="badge succes">'.$ecole['present'].'</span></li>
                            <li class="list-group-item">Absent(s): <span class="badge succes">'.($ecole['effectif']-$ecole['present']).'</span></li>
                            <li class="list-group-item">Fille(s) Absente(s): <span class="badge succes">'.($ecole['fille']-$ecole['fille_present']).'</span></li>
                            <li class="list-group-item">Garçon(s) Absent(s): <span class="badge succes">'.($ecole['garcon']-$ecole['garcon_present']).'</span></li>
                        </ul>

                        <p><button class="btn btn-success btn-block afficherAbsent" id="absent-'.$ecole['id'].'">Afficher les absents</button></p>
                        <p><a class="btn btn-success btn-block afficherTaux" href="taux_presence_enseignant.html" id="taux-'.$ecole['id'].'">Voir le taux de présence par mois</a></p>
                    </div>
                </div>
        </div>';
    }

    return $code;
}


function afficherAbsent($absents)
{
    $liste='<div class="table-responsive">
            <table class="table table-condensed table-bordered">
            <tr>
                    <th style="width: 30%">Enseignant</th>
                    <th style="width: 5%">Début</th>
                    <th style="width: 5%">Fin</th>
                    <th style="width: 50%">Motif</th>
            </tr>';

    foreach ($absents as $absent)
    {
        $liste.='<tr>
                <td>'.$absent['nom'].' '.$absent['prenom'].'</td>
                <td>'.$absent['debut'].'</td>
                <td>'.$absent['fin'].'</td>
                <td>'.$absent['motif'].'</td>
        </tr>';
    }

    $liste.='</table>';

    return $liste;
}


function afficherRegion($listeRegion)
{
    $display='';
    foreach($listeRegion as $region)
    {
        $display.='<option value="'.$region['id'].'">'.$region['nom'].'</option>';
    }

    return $display;						
}


function afficherPrefecture($listePrefecture)
{
    $display='';
    foreach($listePrefecture as $prefecure)
    {
        $display.='<option value="'.$prefecure['id'].'">'.$prefecure['nom'].'</option>';
    }
    
    return $display;
}


if(isset($_GET['idEcole']) && isset($_GET['nomFonction']) && isset($_GET['prefecture']) && isset($_GET['region']) && !isset($_GET['jour']) && !isset($_GET['mois']) && !isset($_GET['annee']))
{
    $mois=date('m');
    $annee=date('Y');
    $jour=date('d');
    $idEcole=(int)$_GET['idEcole'];

    $listeRegion=getRegion();
    $listePrefecture=[];
    if($_GET['nomFonction']=='Responsable Régionale'){
        $idRegion=(int)$_GET['region'];
        $listePrefecture=getPrefecture($idRegion);
    }else if(count($listeRegion)>0){
        $listePrefecture=getPrefecture($listeRegion[0]['id']);
    }

    $region=count($listeRegion)>0?$listeRegion[0]['id']:null;
    $prefecture=count($listeRegion)>0?$listePrefecture[0]['id']:null;

    if($_GET['nomFonction']=='DPE / DCE' || $_GET['nomFonction']=='Directeur général' || $_GET['nomFonction']=='Directeur' || $_GET['nomFonction']=='Proviseur' ||
            $_GET['nomFonction']=='Principal')
    {
        $region=(int)$_GET['region'];
        $prefecture=(int)$_GET['prefecture'];
    }

    $statistique=getStatistique($idEcole, $_GET['nomFonction'], $prefecture, $jour, $mois, $annee, getAnneeScolaire());

	
    $displayStatistique= afficherStatistique($statistique);
    $displayPrefecture= afficherPrefecture($listePrefecture);
    $displayRegion= afficherRegion($listeRegion);
    
    $reponse=['statistique'=>$displayStatistique, 'region'=>$displayRegion, 'prefecture'=>$displayPrefecture];
    echo json_encode($reponse);
}


if(isset($_GET['idEcole']) && isset($_GET['nomFonction']) && isset($_GET['prefecture']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']))
{
    $jour=(int)$_GET['jour'];
    $mois=(int)$_GET['mois'];
    $annee=(int)$_GET['annee'];
    $idEcole=(int)$_GET['idEcole'];
    $prefecture=(int)$_GET['prefecture'];

    if(checkdate($mois, $jour, $annee))
    {
        $date=$annee.'-'.$mois.'-'.$jour;        
    }
    else
    {
        $date= date('Y-m-d');
    }

    $statistique=getStatistique($idEcole, $_GET['nomFonction'], $prefecture, $jour, $mois, $annee, getAnneeScolaire());
    echo afficherStatistique($statistique);
}



if(isset($_GET['changeRegion']))
{
    $region=(int)$_GET['changeRegion'];
    
    $listePrefecture=getPrefecture($region);

    $displayPrefecture= afficherPrefecture($listePrefecture);
    echo $displayPrefecture;
}


if(isset($_GET['idEcole']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && !isset($_GET['nomFonction']) && !isset($_GET['prefecture']))
{
    $idEcole=(int)$_GET['idEcole'];
    $jour=(int)$_GET['jour'];
    $mois=(int)$_GET['mois'];
    $annee=(int)$_GET['annee'];
    
    if(checkdate($mois, $jour, $annee))
    { 
        $date=$annee.'-'.$mois.'-'.$jour;
    }
    else
    {
        $date=date('Y-m-d');
    }
    
    $absents= getAbsent($date, $idEcole);
    echo afficherAbsent($absents);
}