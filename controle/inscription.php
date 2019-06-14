<?php
include_once('modele/connexion_base.php');
include_once('modele/inscription.php');

$annee=date('Y');
$mois=date('m');
$jour=date('d');

$listeClasse=getClasse($_SESSION['user']['idEcole']);

if(isset($_POST['matricule']) && !empty($_POST['matricule']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) &&
	isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['jourNaissance']) &&
	isset($_POST['moisNaissance']) && isset($_POST['passe']) && 
	isset($_POST['anneeNaissance']) && isset($_POST['lieuNaissance']) && isset($_POST['pere']) && 
	isset($_POST['mere']) && isset($_POST['jourInscription']) &&
	isset($_POST['moisInscription']) && 
	isset($_POST['anneeInscription']) &&  isset($_POST['cours']))
{
	$matricule=htmlspecialchars($_POST['matricule']);
	$nom=htmlspecialchars($_POST['nom']);
	$prenom=htmlspecialchars($_POST['prenom']);
	$sexe=htmlspecialchars($_POST['sexe']);
	$jourNaissance=(int)$_POST['jourNaissance'];
	$moisNaissance=(int)$_POST['moisNaissance'];
	$anneeNaissance=(int)$_POST['anneeNaissance'];
	$lieuNaissance=htmlspecialchars($_POST['lieuNaissance']);
	$pere=htmlspecialchars($_POST['pere']);
	$mere=htmlspecialchars($_POST['mere']);
	$jourInscription=(int)$_POST['jourInscription'];
	$moisInscription=(int)$_POST['moisInscription'];
	$anneeInscription=(int)$_POST['anneeInscription'];
	$cours=(int)$_POST['cours'];
	$passe=sha1($_POST['passe']);
	
	$ok=false;
	
	if(!isset($_POST['choixTuteur']) && isset($_POST['tuteur']))
	{
            $idTuteur=(int)$_POST['tuteur'];
            if(tuteurExiste($idTuteur))
                    $ok=true;
	}
	else if(isset($_POST['nomTuteur']) && isset($_POST['adresse']) && 
		isset($_POST['telephone']) && 
		isset($_POST['passeTuteur']))
	{
            $nomTuteur=htmlspecialchars($_POST['nomTuteur']);
            $adresse=htmlspecialchars($_POST['adresse']);
            $telephone=htmlspecialchars($_POST['telephone']);	
            $passeTuteur=sha1($_POST['passeTuteur']);
            $ok=true;
	}
	
	$ecoleOrigine=htmlspecialchars($_POST['ecoleOrigine']);
	$pv=(int)$_POST['pv'];
	$rang=(int)$_POST['rang'];
	$session=(int)$_POST['session'];
	
        if(checkdate($moisNaissance, $jourNaissance, $anneeNaissance))
        {
            $dateNaissance=$anneeNaissance.'-'.$moisNaissance.'-'.$jourNaissance;
        }
        else
        {
            $dateNaissance= date('Y-m-d');
        }
            
        
        if(checkdate($moisInscription, $jourInscription, $anneeInscription))
        {
            $dateInscription=$anneeInscription.'-'.$moisInscription.'-'.$jourInscription;
        }
        else
        {
            $dateInscription=date('Y-m-d');
        }
        
	if($ok)
	{		
            if(!isMatriculeExist($matricule))
            {	
                $tuteur=['nomTuteur'=>$nomTuteur, 'adresse'=>$adresse, 'telephone'=>$telephone, 'passe'=>$passeTuteur, 'idEcole'=>$_SESSION['user']['idEcole']];

                if(isset($_POST['choixTuteur']))
                        $idTuteur=insertTuteur($tuteur);

                $eleve=['id_ecole'=>$_SESSION['user']['idEcole'], 'matricule'=>$matricule, 'nom'=>$nom, 'prenom'=>$prenom, 'sexe'=>$sexe, 'passe'=>$passe,
                'date_naissance'=>$dateNaissance, 'lieu_naissance'=>$lieuNaissance, 'pere'=>$pere, 'mere'=>$mere, 'date_inscription'=>$dateInscription, 
                'id_tuteur'=>$idTuteur, 'cours'=>$cours, 'pv_dernier_examen'=>$pv, 'rang_dernier_examen'=>$rang, 'ecole_origine'=>$ecoleOrigine, 'session_dernier_examen'=>$session];

                $id=insertEleve($eleve, $cours, $_SESSION['annee']);

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

                setcookie('inscription_eleve', 'ok', time()+3);

                header('location: inscription.php');	
            }
            else
                setcookie('inscription_eleve', 'bad', time()+3);
	}
	else
            setcookie('inscription_eleve', 'bad', time()+3);
}
else
    setcookie('inscription_eleve', 'bad', time()+3);

include_once('vue/inscription.php');
