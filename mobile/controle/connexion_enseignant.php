<?php
header('Access-Control-Allow-Origin: *');

$information['connexion']='false';
include_once('../../modele/connexion_base.php');
include_once('../modele/connexion_enseignant.php');
include_once ('../fonction.php');

if(isset($_POST['matricule']) && isset($_POST['passe']) && isset($_POST['ecole']))
{
    if(connexionEnseignant($_POST['matricule'], sha1($_POST['passe']), $_POST['ecole'])){
        $information=getInformationEnseignant($_POST['matricule'], $_POST['ecole']);
        $information['connexion']='true';

        $information['classes']=getClasseEnseignant($information['id'], $information['niveau']);
        $information['matieres']= getMatiere($information['id'], $information['niveau']);
        $information['eleves']= getEleve($information['id'], $information['niveau'], getAnneeScolaire());
        
        $mois=date('m');
        $annee=date('Y');

        if($mois>=9){
            setcookie('annee', $annee.'-'.($annee+1), time()+3600*30);
        }else{
            setcookie('annee', ($annee-1).'-'.$annee, time()+3600*30);
        }
    }

    echo json_encode($information);
}

if(isset($_GET['option']))
{
    $listeEcole=getEcole();
    $code='';
    foreach ($listeEcole as $ecole) {
            $code.='<option value="'.$ecole['id'].'">'.$ecole['nom'].'</option>';
    }

    echo $code;
}