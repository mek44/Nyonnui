<?php
header('Access-Control-Allow-Origin: *');
include_once ('../../modele/connexion_base.php');
include_once('../modele/mensualite_tuteur.php');
include_once ('../fonction.php');

function afficherVersement($listeVersement)
{
    $listeMois=['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    $total=0;
    $display='<table class="table table-striped table-condensed table-bordered">
                <tr>
                        <th>Date</th>
                        <th>Mois</th>
                        <th>Payé</th>
                        <th>Réduction</th>
                        <th>Reçu</th>
                </tr>';
                                
    foreach ($listeVersement as $versement)
    {
        $display.='<tr>
            <td>'.$versement['date_paie'].'</td>
            <td>'.$listeMois[$versement['mois']-1].'</td>
            <td>'.formatageMontant($versement['montant']-$versement['reduction']).'</td>
            <td>'.formatageMontant($versement['reduction']).'</td>
            <td>'.$versement['num_recus'].'</td>
        </tr>';
    
        $total+=$versement['montant']-$versement['reduction'];
    }

    return ['versement'=>$display, 'total'=>$total];
}

if(isset($_GET['idEleve']))
{
    $idEleve=(int)$_GET['idEleve'];
    $infos= getInfoEleve($idEleve, getAnneeScolaire());
    $listeVersement= getVersements($idEleve, getAnneeScolaire());
    
    $displayVersment= afficherVersement($listeVersement);
    $infos['versement']=$displayVersment['versement'];
    $infos['total']= formatageMontant($displayVersment['total']);
    $infos['classe']=formatClasse($infos);
    
    echo json_encode($infos);
}



