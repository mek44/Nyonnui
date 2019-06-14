<?php
include_once('modele/connexion_base.php');
include_once('modele/nouvelle_depense.php');

if(isset($_POST['categorie']) && isset($_POST['montant']) && isset($_POST['beneficiaire']) && isset($_SESSION['user']))
{
    $categorie=(int)$_POST['categorie'];
    $beneficiaire=htmlspecialchars($_POST['beneficiaire']);
    $montant=(int)$_POST['montant'];
    $jour=(int)$_POST['jour'];
    $mois=(int)$_POST['mois'];
    $annee=(int)$_POST['annee'];

    if(checkdate($mois, $jour, $annee))
    {
        $date=$annee.'-'.$mois.'-'.$jour;
        ajouterDepense($categorie, $beneficiaire, $montant, $date, $_SESSION['user']['idEcole'], $_SESSION['annee']);
    }

    header('location: nouvelle_depense.php');
}

$jour=date('d');
$mois=date('m');
$annee=date('Y');
$listeCategorie=[];

if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']==='Comptable' && isset($_SESSION['annee']))
{
    $pageValide=true;
    $listeCategorie=getCategorie($_SESSION['user']['idEcole']);
}

include_once('vue/nouvelle_depense.php');
