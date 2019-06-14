<?php
$pageValide=false;

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='DPE / DCE'))
{	
    include_once('modele/ajouter_ecole.php');
    include_once('modele/connexion_base.php');
    $pageValide=true;

    $observation='';

    $listeEtablissement=getEtablissement();
    $listeCycle=getCycle();

    $listeRegion=getRegion();
    $listePrefecture=[];
    if(count($listeRegion)>0){
        $listePrefecture=getPrefecture($listeRegion[0]['id']);
    }

    if(isset($_COOKIE['enregistrement'])){
        $observation=$_COOKIE['enregistrement'];
    }
    
    if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['telephone']) && 
            !empty($_POST['telephone']) && isset($_POST['prefecture']) && isset($_POST['cycle']) && isset($_POST['etablissement']))
    {
        $cycle=(int)$_POST['cycle'];
        $etablissement=(int)$_POST['etablissement'];
        $cfip=0;
        $partOng=0;
        $partEcole=0;

        if($_SESSION['user']['fonction']=='Super Administrateur' && isset($_POST['cfip']) && isset($_POST['partOng']) && isset($_POST['partEcole']))
        {
            $cfip=1;
            $partEcole=(int)$_POST['partEcole'];
            $partOng=(int)$_POST['partOng'];
        }

        if(!isEcoleExiste($_POST['nom']))
        {
            insertEcole($_POST['prefecture'], $_POST['nom'], $_POST['adresse'], $_POST['telephone'], $etablissement, $cycle, $cfip, $partOng, $partEcole);
            setcookie('nouvelle_ecole', 'L\'école a été enregistrée avec succès', time()+3);
            setcookie('enregistrement', 'succes', time()+3);
            header('location: ajouter_ecole.php');
        }
        else
        {
            setcookie('enregistrement', 'echec', time()+3);
            setcookie('nouvelle_ecole', 'Cette école existe déjà', time()+3);
            header('location: ajouter_ecole.php');
        }	
    }
    else
    {
        setcookie('enregistrement', 'echec', time()+3);
        setcookie('nouvelle_ecole', 'Les données ne sont pas valides', time()+3);
    }
}

include_once('vue/ajouter_ecole.php');