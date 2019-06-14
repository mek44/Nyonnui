<?php
include_once('modele/connexion_base.php');
include_once('modele/modifier_professeur.php');

$observation='';

if(isset($_COOKIE['enregistrement']))
	$observation=$_COOKIE['enregistrement'];

if(isset($_POST['matricule']) && !empty($_POST['matricule']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) &&
	isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['jourNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourNaissance']) &&
	isset($_POST['moisNaissance']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisNaissance']) && isset($_POST['anneeNaissance']) && 
	preg_match('#^[0-9]{4}$#', $_POST['anneeNaissance']) && isset($_POST['lieuNaissance']) && !empty($_POST['lieuNaissance']) &&
	isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['telephone']) && preg_match('#^[0-9][-0-9. ]+$#', $_POST['telephone']) &&
	isset($_POST['jourInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourInscription']) &&
	isset($_POST['moisInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisInscription']) &&
	isset($_POST['anneeInscription']) && preg_match('#^[0-9]{4}$#', $_POST['anneeInscription']) && 
	isset($_POST['fonction']) && !empty($_POST['fonction']) && isset($_POST['salaire']) && !empty($_POST['salaire']) &&
	isset($_POST['taux']) && !empty($_POST['taux']))
{
	$matricule=htmlspecialchars($_POST['matricule']);
	$nom=htmlspecialchars($_POST['nom']);
	$prenom=htmlspecialchars($_POST['prenom']);
	$sexe=htmlspecialchars($_POST['sexe']);
	$jourNaissance=(int)$_POST['jourNaissance'];
	$moisNaissance=(int)$_POST['moisNaissance'];
	$anneeNaissance=(int)$_POST['anneeNaissance'];
	$lieuNaissance=htmlspecialchars($_POST['lieuNaissance']);
	$fonction=htmlspecialchars($_POST['fonction']);
	$adresse=htmlspecialchars($_POST['adresse']);
	$telephone=htmlspecialchars($_POST['telephone']);
	$jourInscription=(int)$_POST['jourInscription'];
	$moisInscription=(int)$_POST['moisInscription'];
	$anneeInscription=(int)$_POST['anneeInscription'];
	$salaire=(int)$_POST['salaire'];
	$taux=(int)$_POST['taux'];
	
	if(checkdate($moisNaissance, $jourNaissance, $anneeNaissance) && checkdate($moisInscription, $jourInscription, $anneeInscription))
	{
		$dateNaissance=$anneeNaissance.'-'.$moisNaissance.'-'.$jourNaissance;
		$dateInscription=$anneeInscription.'-'.$moisInscription.'-'.$jourInscription;
		
		if(isMatriculeExist($matricule))
		{	
			$personnel=['id_ecole'=>$_SESSION['user']['idEcole'], 'matricule'=>$matricule, 'nom'=>$nom, 'prenom'=>$prenom, 'sexe'=>$sexe, 
			'date_naissance'=>$dateNaissance, 'lieu_naissance'=>$lieuNaissance, 'fonction'=>$fonction,
			'date_engagement'=>$dateInscription, 'adresse'=>$adresse, 'telephone'=>$telephone, 'salaire'=>$salaire, 'taux'=>$taux];
			
			$id=updatePersonnel($personnel);
			
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
						move_uploaded_file($_FILES['photo']['tmp_name'], 'imagespersonnel/'.$image);	
						updateImage($id, $image);
					}
				}
			}
			
			setcookie('modifier_professeur', 'Modification effectuée avec succès', time()+3);
			setcookie('enregistrement', 'succes', time()+3);
			header('location: modifier_professeur.php');	
		}
		else
		{
			setcookie('enregistrement', 'echec', time()+3);
			setcookie('modifier_professeur', 'Ce numéro de matricule n\'est attribué à aucun personnel', time()+3);
			header('location: modifier_professeur.php');
		}
			
	}
	else
	{
		setcookie('enregistrement', 'echec', time()+3);
		setcookie('modifier_professeur', 'La date de naissance ou de récrutement n\'est pas valide', time()+3);
		header('location: modifier_professeur.php');	
	}
}
else
{
	setcookie('enregistrement', 'echec', time()+3);
	setcookie('modifier_professeur', 'Les données ne sont pas valides', time()+3);
}
	

include_once('vue/modifier_professeur.php');