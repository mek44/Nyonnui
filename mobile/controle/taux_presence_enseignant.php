<?php
header('Access-Control-Allow-Origin: *');

include_once('../../modele/connexion_base.php');
include_once('../modele/taux_presence_enseignant.php');
include_once('../fonction.php');

function afficherTaux($listeTaux)
{
    $display='';
    foreach($listeTaux as $taux)
    {
        $display.='<div class="col-lg-3 col-xs-12 col-sm-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 class="panel-title">'.$taux['mois'].'</h1>
                </div>

                <div class="panel-body">'.parseReel($taux['taux_presence']).' %</div>
            </div>
        </div>';
    }
    
    return $display;
}

if(isset($_GET['idEcole']) && isset($_GET['nomFonction']))
{
    $idEcole=(int)$_GET['idEcole'];
    $listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
    $moisActuel=date('m');

    $listeTaux=getTauxPresence($idEcole, $listeMois, $moisActuel, getAnneeScolaire());
    
    $titre='Taux de présences des enseignants';
    if($_GET['nomFonction']!='Directeur général' && $_GET['nomFonction']!='Proviseur' && $_GET['nomFonction']!='Principal' && 
            $_GET['nomFonction']!='Directeur' && $_GET['nomFonction']!='Enseignant')
    {  
        $titre.=' de l\'établissement <br />'.getNomEcole($idEcole);
    }

    $taux= afficherTaux($listeTaux);
    $reponse=['taux'=>$taux, 'titre'=>$titre];
    echo json_encode($reponse);
}

