<?php
include_once('modele/connexion_base.php');
include_once('modele/inscription_personnel.php');

$pageValide=false;
$communes=[];
if(isset($_SESSION['user']) && $_SESSION['user']['nom_fonction']==='DRH')
{
    $pageValide=true;
    $communes=getPrefecture($_SESSION['user']['id_region']);
}


if(isset($_POST['matricule']) && !empty($_POST['matricule']) && isset($_POST['cin']) && !empty($_POST['cin']) && isset($_POST['nom']) && !empty($_POST['nom']) && 
        isset($_POST['prenom']) && !empty($_POST['prenom']) &&
	isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['jourNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourNaissance']) &&
	isset($_POST['moisNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisNaissance']) &&
	isset($_POST['anneeNaissance']) && preg_match('#^[0-9]{4}$#', $_POST['anneeNaissance']) && isset($_POST['lieuNaissance']) && !empty($_POST['lieuNaissance']) && 
        isset($_POST['adresse']) && isset($_POST['email']) &&
        isset($_POST['telephone']) && preg_match('#^[0-9][-0-9._ ]+$#', $_POST['telephone']) && isset($_POST['personne_contact']) && !empty($_POST['personne_contact']) &&
        isset($_POST['telephone_contact']) && !empty($_POST['telephone_contact']) && isset($_POST['categorie']) && !empty($_POST['categorie']) && 
        isset($_POST['commune']) && !empty($_POST['commune']) && isset($_POST['responsabilite']) && !empty($_POST['responsabilite']))
{
	$matricule=htmlspecialchars($_POST['matricule']);
        $cin=htmlspecialchars($_POST['cin']);
	$nom=htmlspecialchars($_POST['nom']);
	$prenom=htmlspecialchars($_POST['prenom']);
	$sexe=htmlspecialchars($_POST['sexe']);
	$jourNaissance=(int)$_POST['jourNaissance'];
	$moisNaissance=(int)$_POST['moisNaissance'];
	$anneeNaissance=(int)$_POST['anneeNaissance'];
	$lieuNaissance=htmlspecialchars($_POST['lieuNaissance']);
	$adresse=htmlspecialchars($_POST['adresse']);
	$email=htmlspecialchars($_POST['email']);
        $telephone=htmlspecialchars($_POST['telephone']);
	$personneContact=htmlspecialchars($_POST['personne_contact']);
        $telephoneContact=htmlspecialchars($_POST['telephone_contact']);
        $categorie=htmlspecialchars($_POST['categorie']);
        $responsabilite=htmlspecialchars($_POST['responsabilite']);
        $commune=(int)$_POST['commune'];
	
        $ok=true;
        
        if(!empty($email) && !preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $email))
            $ok=false;
        
	if(checkdate($moisNaissance, $jourNaissance, $anneeNaissance) && $ok)
	{
            $dateNaissance=$anneeNaissance.'-'.$moisNaissance.'-'.$jourNaissance;

            if(!isMatriculeExist($matricule))
            {	

                $personnel=['matricule'=>$matricule, 'cin'=>$cin, 'nom'=>$nom, 'prenom'=>$prenom, 'sexe'=>$sexe,
                'date_naissance'=>$dateNaissance, 'lieu_naissance'=>$lieuNaissance, 'adresse'=>$adresse, 'email'=>$email, 'telephone'=>$telephone, 'personneContact'=>$personneContact,
                'telephoneContact'=>$telephoneContact, 'categorie'=>$categorie, 'commune'=>$commune, 'responsabilite'=>$responsabilite];

                insertPersonnel($personnel);

                setcookie('inscription_personnel', 'ok', time()+3);

                header('location: inscription_personnel.php');	
            }
            else
                setcookie('inscription_personnel', 'bad', time()+3);
	}
	else
            setcookie('inscription_personnel', 'bad', time()+3);
}

include_once('vue/inscription_personnel.php');
