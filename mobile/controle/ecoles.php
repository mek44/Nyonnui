<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/ecoles.php');
include_once('../fonction.php');

function afficherStatistique($prefecture)
{
    $primaire=[];
    $college=[];
    $lycee=[];
    
    $listeCycle=getCycle();

    foreach($listeCycle as $cycle)
    {
        if($cycle['libelle']=='Primaire'){
            $primaire=getStatistique($prefecture, $cycle['id']);
        }else if($cycle['libelle']=='Collège'){
            $college=getStatistique($prefecture, $cycle['id']);
        }else{
            $lycee=getStatistique($prefecture, $cycle['id']);
        }
    }
    
    $display='<div class="col-lg-2 col-lg-offset-3 col-xs-12 col-sm-2 col-sm-offset-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h1 class="panel-title">Primaire</h1>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">';
    $total=0;                                   
    foreach ($primaire as $etablissement) 
    {
        $display.='<li class="list-group-item">'.$etablissement['etablissement'].': <span class="badge succes">'.$etablissement['nombre'].'</span></li>';
        $total+=$etablissement['nombre'];
    }
    
    $display.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
                </ul>
            </div>
        </div>
    </div>';
    
    $total=0;
    

    $display.='<div class="col-lg-2 col-xs-12 col-sm-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 class="panel-title">Collège</h1>
                </div>
                <div class="panel-body">
                    <ul class="list-group">';
								
    foreach ($college as $etablissement) 
    {
        $display.='<li class="list-group-item">'.$etablissement['etablissement'].': <span class="badge succes">'.$etablissement['nombre'].'</span></li>';

        $total+=$etablissement['nombre'];
    }
   
    $display.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
                </ul>
            </div>
        </div>
    </div>';

    $total=0;

    $display.='<div class="col-lg-2 col-xs-12 col-sm-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 class="panel-title">Lycée</h1>
                </div>
                <div class="panel-body">
                    <ul class="list-group">';
                                   
    foreach ($lycee as $etablissement) 
    {
        $display.='<li class="list-group-item">'.$etablissement['etablissement'].': <span class="badge succes">'.$etablissement['nombre'].'</span></li>';

        $total+=$etablissement['nombre'];
    }

    $display.='<li class="list-group-item">Total: <span class="badge succes">'.$total.'</span></li>
            </ul>
            </div>
        </div>
    </div>';

    return $display;
}


function afficherEcole($listeEcole)
{
    $display='<h1>Liste des écoles</h1>';
			
    foreach($listeEcole as $ecole)
    {
        $display.='<div class="col-lg-3 col-xs-12 col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h1 class="panel-title">'.$ecole['nom'].'</h1>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Région: '.$ecole['nom_region'].'</li>
                            <li class="list-group-item">Préfecture: '.$ecole['nom_pref'].'</li>
                            <li class="list-group-item">Adresse: '.$ecole['adresse'].'</li>
                            <li class="list-group-item">Téléphone: '.$ecole['telephone'].'</li>
                            <li class="list-group-item">Effectif: <span class="badge succes">'.$ecole['effectif'].'</span></li>
                            <li class="list-group-item">Garçon(s): <span class="badge succes">'.$ecole['garcon'].'</span></li>
                            <li class="list-group-item">Fille(s): <span class="badge succes">'.$ecole['fille'].'</span></li>
                        </ul>

                        <p><a class="btn btn-success btn-block afficherStatistique" href="statistique_presence.html" id="'.$ecole['id'].'">Statistiques des élèves</a></p>
                        
                    </div>
                </div>
        </div>';
    }
    
    
    //<a href="modifier_ecole.html" id="'.$ecole['id'].'" class="btn btn-success">Modifier</a>
    return $display;
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


function afficherCycle($listeCycle)
{
    $display='';
    foreach($listeCycle as $cycle)
    {
        $display.='<option value="'.$cycle['id'].'">'.$cycle['libelle'].'</option>';
    }
    
    return $display;
}


if(isset($_GET['nomFonction']) && isset($_GET['idRegion']) && isset($_GET['idPrefecture']) && !isset($_GET['cycle']))
{
    $idRegion=(int)$_GET['idRegion'];
    $idPrefecture=(int)$_GET['idPrefecture'];
    
    $listeCycle=getCycle();
    $listeRegion=getRegion();

    $listePrefecture=[];
    if($_GET['nomFonction']=='Responsable Régionale'){
        $listePrefecture=getPrefecture($idRegion);
    }else if(count($listeRegion)>0){
        $listePrefecture=getPrefecture($listeRegion[0]['id']);
    }
    $region=count($listeRegion)>0?$listeRegion[0]['id']:null;
    $prefecture=count($listePrefecture)>0?$listePrefecture[0]['id']:null;

    $listeEcole=[];
    if($_GET['nomFonction']=='Super Administrateur' || $_GET['nomFonction']=='Partenaire'){
        $listeEcole=getEcole(getAnneeScolaire(), $region, $prefecture, $listeCycle[0]['id']);
    }else {
        $listeEcole=getEcole(getAnneeScolaire(), $idRegion, $idPrefecture, $listeCycle[0]['id']);
        $prefecture=$idPrefecture;
    }

    
    $displayStatistique= afficherStatistique($prefecture);
    $displayEcole= afficherEcole($listeEcole);
    $displayRegion= afficherRegion($listeRegion);
    $displayPrefecture= afficherPrefecture($listePrefecture);
    $displayCycle= afficherCycle($listeCycle);
    
    
    $reponse=['statistique'=>$displayStatistique, 'ecoles'=>$displayEcole, 'region'=>$displayRegion, 'prefecture'=>$displayPrefecture, 'cycle'=>$displayCycle];
    echo json_encode($reponse);
}




if(isset($_GET['region']) && isset($_GET['cycle']))
{
    $idRegion=(int)$_GET['region'];
    $cycle=(int)$_GET['cycle'];

    $listePrefecture=getPrefecture($idRegion);

    $displayPrefecture= afficherPrefecture($listePrefecture);

    $ecole=[];
    if(count($listePrefecture)>0)
        $ecole=getEcole(getAnneeScolaire(), $idRegion, $listePrefecture[0]['id'], $cycle);

    $displayEcole= afficherEcole($ecole);

    $prefecture=0;
    if(count($listePrefecture)>0){
        $prefecture=$listePrefecture[0]['id'];
    }
    
    $displayStatistique= afficherStatistique($prefecture);

    echo json_encode(['prefecture'=>$displayPrefecture, 'ecoles'=>$displayEcole, 'statistique'=>$displayStatistique]);
}


if(isset($_GET['idPrefecture']) && isset($_GET['cycle']) && isset($_GET['nomFonction']) && isset($_GET['idRegion']))
{	
    $prefecture=(int)$_GET['idPrefecture'];
    $cycle=(int)$_GET['cycle'];
    $region=(int)$_GET['idRegion'];

    if($_GET['nomFonction']=='Super Administrateur' || $_GET['nomFonction']=='Partenaire')
        $region=null;

    $displayStatistique= afficherStatistique($prefecture);
    $ecoles=getEcole(getAnneeScolaire(), $region, $prefecture, $cycle);
    $displayEcole= afficherEcole($ecoles);

    echo json_encode(['ecoles'=>$displayEcole, 'statistique'=>$displayStatistique]);
}