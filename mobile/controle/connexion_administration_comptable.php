<?php
header('Access-Control-Allow-Origin: *');
$information['connexion']='false';

if(isset($_POST['login']) && isset($_POST['passe']))
{
    include_once('../../modele/connexion_base.php');
    include_once('../modele/connexion_administration_comptable.php');

    if(connexionAdminComptable($_POST['login'], sha1($_POST['passe']))){
        $information=getInformation($_POST['login']);
        $information['connexion']='true';
        
        $mois=date('m');
        $annee=date('Y');

        if($mois>=9){
            setcookie('annee', $annee.'-'.($annee+1), time()+3600*30);
        }else{
            setcookie('annee', ($annee-1).'-'.$annee, time()+3600*30);
        }
    }
}

echo json_encode($information);