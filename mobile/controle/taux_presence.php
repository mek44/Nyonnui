<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/taux_presence.php');
include_once('../fonction.php');
	

if(isset($_GET['idEcole']) && isset($_GET['nomFonction']))
{	
    $listeMois=['Septembre'=>9, 'Octobre'=>10, 'Novembre'=>11, 'Décembre'=>12, 'Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8];
    $moisActuel=date('m');

    $idEcole=(int)$_GET['idEcole'];
    
    $ecole=getNomEcole($idEcole);
    $listeTaux=getTauxPresence($idEcole, $listeMois, $moisActuel, getAnneeScolaire());
    $display='';
    
    foreach($listeTaux as $taux)
    {
        $display.='<div class="col-lg-3 col-xs-12 col-sm-3">
            <div class="panel panel-success">
                    <div class="panel-heading">
                        <h1 class="panel-title">'.$taux['mois'].'</h1>
                    </div>

                    <div class="panel-body">'.parseReel($taux['taux_presence']).' % </div>
            </div>
        </div>';
    }
    
    $titre='Taux de présences des élèves ';
    if($_GET['nomFonction']!='Directeur général' && $_GET['nomFonction']!='Proviseur' && $_GET['nomFonction']!='Principal' && 
            $_GET['nomFonction']!='Directeur' && $_GET['nomFonction']!='Enseignant')
    {  
        $titre.=' de l\'établissement <br />'.getNomEcole($idEcole);
    }

    echo json_encode(['taux'=>$display, 'titre'=>$titre]);
}
