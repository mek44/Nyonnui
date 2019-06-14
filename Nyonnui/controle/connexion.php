<?php
global $base;

include_once('modele/connexion_base.php');
include_once('modele/connexion.php');


//$listeEcole=getEcole();

$type='admin_compta';

$listeType=['admin_compta', 'partenaires', 'enseignants', 'parents','eleves'];
if(filter_input(INPUT_GET,'type')!==NULL && in_array(filter_input(INPUT_GET,'type'), $listeType))
{
    $type=filter_input(INPUT_GET,'type');
} elseif (filter_input(INPUT_POST,'type')!== NULL && in_array(filter_input(INPUT_POST,'type'), $listeType)) {
    $type=filter_input(INPUT_POST,'type');
}else{$type = '';}

if (filter_input(INPUT_POST,'login')!==NULL) {
    $login=filter_input(INPUT_POST,'login');
}else{$login = '';}

if (filter_input(INPUT_POST,'passe')!==NULL) {
    $passe=filter_input(INPUT_POST,'passe');
}else{$passe = '';}

if (filter_input(INPUT_POST,'ecole')!==NULL) {
    $ecole=filter_input(INPUT_POST,'ecole');
}else{$ecole = '';}

$libelleLogin='';
if($type=='admin_compta' || $type=='partenaires'){
	$libelleLogin='Login :';
}else{
    $libelleLogin='Matricule: ';}

if($login!='' && $passe != '' && $type != '')
{
	if($type=='enseignants'){
		$connexion= connexionEnseignant($login, sha1($passe), $ecole);
	}elseif($type=='admin_compta'){
		$connexion=connexionAdminComptable($login, sha1($passe));
        }elseif($type=='partenaires'){
		$connexion=connexionPartenaire($login, sha1($passe));
        }elseif($type=='parents'){
        $connexion= connexionParent($login, sha1($passe), $ecole);
	}elseif ($type=='eleves'){
        $connexion= connexionEleve($login, sha1($passe), $ecole);
	}
/*        else if($type=='parents_eleves' && isset ($_POST['parent_eleve'])){
            $parentEleve=$_POST['parent_eleve'];
            if($parentEleve=='eleve'){
				$ecole = (int)getEcoleByLogin($_POST['login'],sha1($_POST['passe']));
                $connexion= connexionEleve($_POST['login'],  sha1($_POST['passe']), $ecole);
            }else{
                $connexion= connexionParent($_POST['login'], sha1($_POST['passe']), $ecole);
            }*/
}
	
	if($connexion)
	{
            if($type==='partenaires' || $type==='admin_compta'){
                $_SESSION['user']=getInformation($login);
            }elseif($type==='enseignants'){
                $_SESSION['user']= getInformationEnseignant($login, $ecole);
            }elseif ($type==='parents'){
                $_SESSION['user']= getInformationParent($login, $ecole);
            }elseif ($type==='eleves'){
                $_SESSION['user']= getInformationEleve($login, $ecole);
                header('location: bulletin.php?id='.$_SESSION['id']);
            }
// code de la version vico
 /*           }else if($type=='parents_eleves'){
                $parentEleve=$_POST['parent_eleve'];
                if($parentEleve=='eleve'){
                    $_SESSION['user']= getInformationEleve($_POST['login'], $ecole);
                    header('location: bulletin.php?id='.$_SESSION['id']);
                }else{
                    $_SESSION['user']= getInformationParent($_POST['login'], $ecole);
                }*/
            
            header('location: indexvico.php');
	}
	else
	{
            setcookie('echec_connexion', 'oui', time()+3);
            header('location: index.php?status=failed');
	}	

/*include_once('vue/connexion.php');*/
