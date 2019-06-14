<?php
global $base;
include_once('modele/connexion_base.php');
include_once('modele/connexion.php');

if(isset($_POST['login'])) {$login=$_POST['login'];}else{$login='';}
if(isset($_POST['passe'])) {$passe=$_POST['passe'];}else{$passe='';};
if(isset($_POST['login'])) {$login=$_POST['login'];}else{$login='';};
if(isset($_POST['login'])) {$login=$_POST['login'];}else{$login='';};

$listeEcole=getEcole();

$type='admin_compta';


$listeType=['admin_compta', 'partenaires', 'enseignants', 'parents','eleves'];

if(isset($_GET['type']) && in_array($_GET['type'], $listeType))
{
    $type=$_GET['type'];
} elseif (isset($_POST['type']) && in_array($_POST['type'], $listeType)) {
    $type=$_POST['type'];
}

$libelleLogin='';
if($type=='admin_compta' || $type=='partenaires')
	$libelleLogin='Login :';
else
	$libelleLogin='Matricule: ';

if($login!='' && $passe!='' && $type!='')
{

	$ecole=0;
	
	if($ecole!='')
		$ecole=(int)$ecole;

	if($type=='enseignants'){
		$connexion= connexionEnseignant($login, sha1($passe), $ecole);
	}elseif($type=='admin_compta')
		$connexion=connexionAdminComptable($login, sha1($login));
	elseif($type=='partenaires')
		$connexion=connexionPartenaire($login, sha1($login));
	elseif($type=='parents'){
        $connexion= connexionParent($login, sha1($login), $ecole);
	}elseif ($type=='eleves'){
        $connexion= connexionEleve($login,  sha1($login), $ecole);
	}
/*        else if($type=='parents_eleves' && isset ($_POST['parent_eleve'])){
            $parentEleve=$_POST['parent_eleve'];
            if($parentEleve=='eleve'){
				$ecole = (int)getEcoleByLogin($login,sha1($login));
                $connexion= connexionEleve($login,  sha1($login), $ecole);
            }else{
                $connexion= connexionParent($login, sha1($login), $ecole);
            }*/
}
	
	if($connexion)
	{
	    echo "$type==='eleves'".($type==='eleves');
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
                    $_SESSION['user']= getInformationEleve($login, $ecole);
                    header('location: bulletin.php?id='.$_SESSION['id']);
                }else{
                    $_SESSION['user']= getInformationParent($login, $ecole);
                }*/
            
            header('location: indexvico.php');
	}
	else
	{
            setcookie('echec_connexion', 'oui', time()+3);
            header('location: connexionnui.php?type='.$type);
	}	

include_once('vue/connexion.php');
