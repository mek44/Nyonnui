<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
	include_once('modele/connexion_base.php');
	include_once('modele/statistique_presence.php');
        include_once ('fonction.php');
	
	$mois=date('m');
	$annee=date('Y');
	$jour=date('d');
	
	$date=date('Y-m-d');
	
	$ok=true;
	
	$nomEcole='';
	
	if($_SESSION['user']['nom_fonction']!='Comptable')
		$pageValide=true;
	
        if($_SESSION['user']['nom_fonction']!='Directeur général' && $_SESSION['user']['nom_fonction']!='Proviseur' && $_SESSION['user']['nom_fonction']!='Principal' &&
		$_SESSION['user']['nom_fonction']!='Directeur' && $_SESSION['user']['nom_fonction']!='Enseignant' && !isset($_GET['id_ecole'])){
            $pageValide=false;
        }
        
	if($_SESSION['user']['nom_fonction']!='Directeur général' && $_SESSION['user']['nom_fonction']!='Proviseur' && $_SESSION['user']['nom_fonction']!='Principal' &&
		$_SESSION['user']['nom_fonction']!='Directeur' && $_SESSION['user']['nom_fonction']!='Enseignant')
	{
            $idEcole=$_GET['id_ecole'];
            $nomEcole=getEcole($idEcole);
	}
	else{
            $idEcole=$_SESSION['user']['idEcole'];
        }
        
        $classeEnseignant=[];
        if($_SESSION['user']['nom_fonction']=='Enseignant'){
            $classeEnseignant=getClasseEnseignant($_SESSION['user']);
        }
        
	$lienTaux='taux_presence.php';
	if($_SESSION['user']['nom_fonction']!='Directeur général' && $_SESSION['user']['nom_fonction']!='Proviseur' && $_SESSION['user']['nom_fonction']!='Principal' &&
		$_SESSION['user']['nom_fonction']!='Directeur' && $_SESSION['user']['nom_fonction']!='Enseignant'){
            $lienTaux.='?id_ecole='.$idEcole;
        }
	$statistique=getStatistique($idEcole, $_SESSION['annee'], $date);
	
}

include_once('vue/statistique_presence.php');