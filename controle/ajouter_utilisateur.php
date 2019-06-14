<?php
$pageValide=true;

if(isset($_SESSION['user']))
{	
	include_once('modele/ajouter_utilisateur.php');
	include_once('modele/connexion_base.php');

	$listeRegion=getRegion();
	$listeFonction=getFonction();
	$listePrefecture=[];
	
	if($_SESSION['user']['nom_fonction']!='Super Administrateur')
		$pageValide=false;
	
	if(is_array($listeRegion) && count($listeRegion)>0)
		$listePrefecture=getPrefecture($listeRegion[0]['id']);
	
	$prefecture=null;
	
	if(is_array($listePrefecture) && count($listePrefecture)>0)
		$prefecture=$listePrefecture[0]['id'];
	
	$listeEcole=getEcole($prefecture);
	
	$observation='';

	if(isset($_COOKIE['enregistrement']))
		$observation=$_COOKIE['enregistrement'];

	if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['adresse']) && 
		!empty($_POST['adresse']) && isset($_POST['telephone']) && !empty($_POST['telephone']) && isset($_POST['login']) && !empty($_POST['login']) && 
		isset($_POST['passe']) && !empty($_POST['passe']) && isset($_POST['confirmation']) && !empty($_POST['confirmation']) && 
		$_POST['passe']==$_POST['confirmation'] && isset($_POST['fonction']) && !empty($_POST['fonction']) && isset($_POST['region']) && 
			!empty($_POST['region']) && isset($_POST['prefecture']) && !empty($_POST['prefecture']))
	{
            //if(isset($_POST['ecole']) && !empty($_POST['ecole']))
		if(!isLoginExiste($_POST['login']))
		{
                    $fonction=(int)$_POST['fonction'];
                    $region=(int)$_POST['region'];
                    $prefecture=(int)$_POST['prefecture'];

                    insertUtilisateur($region, $prefecture, $_POST['ecole'], $_POST['nom'], $_POST['adresse'], $_POST['telephone'], $_POST['login'], 
                    sha1($_POST['passe']), $fonction);
                    setcookie('nouveau_user', 'L\'utilisateur a été enregistrée avec succès', time()+3);
                    setcookie('enregistrement', 'succes', time()+3);
                    header('location: ajouter_utilisateur.php');
		}
		else
		{
			setcookie('enregistrement', 'echec', time()+3);
			setcookie('nouveau_user', 'Cet login existe déjà', time()+3);
			header('location: ajouter_utilisateur.php');
		}	
	}
	else
	{
		setcookie('enregistrement', 'echec', time()+3);
		setcookie('nouveau_user', 'Les données ne sont pas valides', time()+3);
	}
}
else
	$pageValide=false;


include_once('vue/ajouter_utilisateur.php');