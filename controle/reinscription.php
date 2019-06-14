<?php
include_once('modele/connexion_base.php');
include_once('modele/reinscription.php');

$listeClasse=getClasse($_SESSION['user']['idEcole']);

if(isset($_POST['matricule']) && !empty($_POST['matricule']) && isset($_POST['nomTuteur']) && !empty($_POST['nomTuteur']) && 
	isset($_POST['adresse']) && !empty($_POST['adresse']) && isset($_POST['telephone']) && preg_match('#^[0-9][-0-9. ]+$#', $_POST['telephone']) &&
	isset($_POST['jourInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['jourInscription']) &&
	isset($_POST['moisInscription']) && preg_match('#^[0-9]{1,2}$#', $_POST['moisInscription']) &&
	isset($_POST['anneeInscription']) && preg_match('#^[0-9]{4}$#', $_POST['anneeInscription']) && isset($_POST['cours']))
{
	$matricule=htmlspecialchars($_POST['matricule']);
	$nomTuteur=htmlspecialchars($_POST['nomTuteur']);
	$adresse=htmlspecialchars($_POST['adresse']);
	$telephone=htmlspecialchars($_POST['telephone']);
	$jourInscription=(int)$_POST['jourInscription'];
	$moisInscription=(int)$_POST['moisInscription'];
	$anneeInscription=(int)$_POST['anneeInscription'];
	$cours=(int)$_POST['cours'];
	
	$pv=(int)$_POST['pv'];
	$rang=(int)$_POST['rang'];
	$session=(int)$_POST['session'];
	
	if(checkdate($moisInscription, $jourInscription, $anneeInscription))
	{
		$dateInscription=$anneeInscription.'-'.$moisInscription.'-'.$jourInscription;
		
		if(isMatriculeExist($matricule))
		{	
			$tuteur=['nomTuteur'=>$nomTuteur, 'adresse'=>$adresse, 'telephone'=>$telephone];
			updateTuteur($tuteur, $matricule, $_SESSION['user']['idEcole']);
			
			$eleve=['id_ecole'=>$_SESSION['user']['idEcole'], 'matricule'=>$matricule, 'date_inscription'=>$dateInscription, 
			'cours'=>$cours, 'pv_dernier_examen'=>$pv, 'rang_dernier_examen'=>$rang, 'session_dernier_examen'=>$session];
			
			updateEleve($eleve, $cours, $_SESSION['annee']);
			
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
						updateImage($matricule, $_SESSION['user']['idEcole'], $image);
					}
				}
			}
			
			setcookie('reinscription_eleve', 'ok', time()+3);
			
			header('location: reinscription.php');	
		}
		else
			setcookie('reinscription_eleve', 'bad', time()+3);
	}
	else
		setcookie('reinscription_eleve', 'bad', time()+3);
}
else
	setcookie('reinscription_eleve', 'bad', time()+3);

include_once('vue/reinscription.php');