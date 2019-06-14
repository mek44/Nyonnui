<?php
session_start();
include_once('../modele/connexion_base.php');
include_once('../modele/modifier_eleve.php');

$mois=date('m');
$year=date('Y');

if($mois>=7)
	$annee=$year.'-'.($year+1);
else
	$annee=($year-1).'-'.$year;

$observation='';

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];
	
if(isset($_POST['matricule']) && !empty($_POST['matricule']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) &&
	isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['jourNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourNaissance']) &&
	isset($_POST['moisNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisNaissance']) && 
	isset($_POST['anneeNaissance']) && preg_match('#^[0-9]{4}$#', $_POST['anneeNaissance']) && 
	isset($_POST['lieuNaissance']) && !empty($_POST['lieuNaissance']) && isset($_POST['pere']) && !empty($_POST['pere']) &&
	isset($_POST['mere']) && !empty($_POST['mere']) && isset($_POST['nomTuteur']) && !empty($_POST['nomTuteur']) && 
	isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['telephone']) && preg_match('#^[0-9][-0-9. ]+$#', $_POST['telephone']) &&
	isset($_POST['jourInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourInscription']) &&
	isset($_POST['moisInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisInscription']) &&
	isset($_POST['anneeInscription']) && preg_match('#^[0-9]{4}$#', $_POST['anneeInscription']) && isset($_POST['cours']))
{
	$matricule=htmlspecialchars($_POST['matricule']);
	$nom=htmlspecialchars($_POST['nom']);
	$prenom=htmlspecialchars($_POST['prenom']);
	$sexe=htmlspecialchars($_POST['sexe']);
	$jourNaissance=(int)$_POST['jourNaissance'];
	$moisNaissance=(int)$_POST['moisNaissance'];
	$anneeNaissance=(int)$_POST['anneeNaissance'];
	$lieuNaissance=htmlspecialchars($_POST['lieuNaissance']);
	$mere=htmlspecialchars($_POST['mere']);
	$pere=htmlspecialchars($_POST['pere']);
	$nomTuteur=htmlspecialchars($_POST['nomTuteur']);
	$adresse=htmlspecialchars($_POST['adresse']);
	$telephone=htmlspecialchars($_POST['telephone']);
	$jourInscription=(int)$_POST['jourInscription'];
	$moisInscription=(int)$_POST['moisInscription'];
	$anneeInscription=(int)$_POST['anneeInscription'];
	$cours=(int)$_POST['cours'];
	
	$ecoleOrigine=htmlspecialchars($_POST['ecoleOrigine']);
	$pv=(int)$_POST['pv'];
	$rang=(int)$_POST['rang'];
	$session=(int)$_POST['session'];
	
	if(checkdate($moisNaissance, $jourNaissance, $anneeNaissance) && checkdate($moisInscription, $jourInscription, $anneeInscription))
	{
		$dateNaissance=$anneeNaissance.'-'.$moisNaissance.'-'.$jourNaissance;
		$dateInscription=$anneeInscription.'-'.$moisInscription.'-'.$jourInscription;
		
		if(isMatriculeExist($matricule))
		{	
			$tuteur=['nomTuteur'=>$nomTuteur, 'adresse'=>$adresse, 'telephone'=>$telephone];
			updateTuteur($tuteur, $matricule, $_SESSION['user']['idEcole']);
			
			$eleve=['id_ecole'=>$_SESSION['user']['idEcole'], 'matricule'=>$matricule, 'nom'=>$nom, 'prenom'=>$prenom, 'sexe'=>$sexe, 
			'date_naissance'=>$dateNaissance, 'lieu_naissance'=>$lieuNaissance, 'pere'=>$pere, 'mere'=>$mere, 'date_inscription'=>$dateInscription, 
			'cours'=>$cours, 'pv_dernier_examen'=>$pv, 'rang_dernier_examen'=>$rang, 'ecole_origine'=>$ecoleOrigine, 'session_dernier_examen'=>$session];
			
			$id=updateEleve($eleve, $annee);
			
			if(isset($_FILES['photo']) && $_FILES['photo']['error']==0)
			{
				$extentionAutorosee=array('jpg', 'jpeg', 'png');
				if($_FILES['photo']['size']<=5000000)
				{
					$infoFichier=pathinfo($_FILES['photo']['name']);
					$extention=$infoFichier['extension'];
					if(in_array($extention, $extentionAutorosee))
					{
						$image=$id.'.'.$extention;	
						move_uploaded_file($_FILES['photo']['tmp_name'], 'imageseleves/'.$image);	
						updateImage($id, $image);
					}
				}
			}
			
			setcookie('enregistrement', 'succes', time()+3);
			setcookie('modifier_eleve', 'Modification effectuée avec succès', time()+3);
			//header('location: modifier_eleve.php');	
			
			echo 'fat';
		}
		else
		{
			setcookie('modifier_eleve', 'Ce numéro de matricule n\'est attribué à aucun élève', time()+3);
			setcookie('enregistrement', 'echec', time()+3);
			//header('location: modifier_eleve.php');		
			echo 'matricule';
		}
			
	}
	else
	{
		setcookie('modifier_eleve', 'La date de naissance naissance ou d\'inscription n\'est pas valide', time()+3);
		setcookie('enregistrement', 'echec', time()+3);
		//header('location: modifier_eleve.php');	
		echo 'date';
	}
		
}
else
{
	setcookie('modifier_eleve', 'Les données ne sont pas valides', time()+3);
	setcookie('enregistrement', 'echec', time()+3);
	echo 'invalide';
}