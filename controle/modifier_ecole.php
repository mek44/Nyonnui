<?php
if(isset($_SESSION['user']) && isset($_GET['id']))
{	
    include_once('modele/modifier_ecole.php');
    include_once('modele/connexion_base.php');

    $id=(int)$_GET['id'];
    $information=getInformation($id);

    $observation='';

    $listeEtablissement=getEtablissement();
    $listeCycle=getCycle();

    $listeRegion=getRegion();
    $listePrefecture=[];

    $listePrefecture=getPrefecture($information['id_region']);

    if(isset($_COOKIE['enregistrement']))
            $observation=$_COOKIE['enregistrement'];

    if(isset($_POST['id']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['telephone']) && 
            !empty($_POST['telephone']) && isset($_POST['prefecture']) && isset($_POST['cycle']) && isset($_POST['etablissement']))
    {
        $cycle=(int)$_POST['cycle'];
        $etablissement=(int)$_POST['etablissement'];
        $id=(int)$_POST['id'];

        if(!isEcoleExiste($_POST['nom'], $id))
        {
            updateEcole($id, $_POST['prefecture'], $_POST['nom'], $_POST['adresse'], $_POST['telephone'], $etablissement, $cycle);
            setcookie('modification_ecole', 'L\'école a été modifiée avec succès', time()+3);
            setcookie('enregistrement', 'succes', time()+3);
            header('location: modifier_ecole.php?id='.$id);
        }
        else
        {
            setcookie('enregistrement', 'echec', time()+3);
            setcookie('modification_ecole', 'Cette école existe déjà', time()+3);
            header('location: modifier_ecole.php?id='.$id);
        }	
    }
    else
    {
        setcookie('enregistrement', 'echec', time()+3);
        setcookie('modification_ecole', 'Les données ne sont pas valides', time()+3);
    }

}

include_once('vue/modifier_ecole.php');
?>