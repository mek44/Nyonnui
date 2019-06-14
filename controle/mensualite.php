<?php
include_once('modele/connexion_base.php');
include_once('modele/mensualite.php');
include_once ('fonction.php');
$listeMois=['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

$jourActuel=date('d');
$moisActuel=date('m');
$anneeActuel=date('Y');

$pageValide=false;
$observation='';

if(isset($_SESSION['user']) && ($_SESSION['user']['nom_fonction']=='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général')) 
{
    $pageValide=true;
	
	if(isset($_COOKIE['mensualite']))
		$observation=$_COOKIE['mensualite'];

	if(isset($_POST['mois']) && isset($_POST['montant']) && isset($_POST['idEleve']) && isset($_POST['jourPaie']) && isset($_POST['moisPaie']) && 
		isset($_POST['anneePaie']) && isset($_POST['recu']) && isset($_POST['reduction']))
	{
		$mois=(int)$_POST['mois'];
                $libelle=$_POST['libelle'];
		$montant=(int)$_POST['montant'];
		$reduction=(int)$_POST['reduction'];
		$idEleve=(int)$_POST['idEleve'];
		$jourPaie=(int)$_POST['jourPaie'];
		$moisPaie=(int)$_POST['moisPaie'];
		$anneePaie=(int)$_POST['anneePaie'];
		$recu=htmlspecialchars($_POST['recu']);
		
		$info=getInfo($idEleve, $_SESSION['annee']);
		
		if($idEleve>0 && $mois>0 && $mois<14 && $montant>0 && $reduction>=0 && checkdate($moisPaie, $jourPaie, $anneePaie))
		{
			$date=$anneePaie.'-'.$moisPaie.'-'.$jourPaie;
			if(!mensualitePaye($idEleve, $mois))
			{
				paiementMensualite($idEleve, $mois, $date, $libelle, $montant, $reduction, $recu);
				setcookie('mensualite', 'succes', time()+3);
				
				$classe= formatClasse($info);
				
				$montant-=$reduction;
				$nom=$info['nom'].' '.$info['prenom'];
				
				header('location: recu_mensualite.php?ecole='.$info['nom_ecole'].'&nom='.$nom.'&date='.$date.'&mois='.$listeMois[$mois-1].'&recu='.$recu.'&matricule='.$info['matricule'].'&classe='.$classe.'&montant='.$montant.'&reduction='.$reduction);
			}
			else{
				setcookie('mensualite', 'echec', time()+3);
				header('location: mensualite.php');
			}
		}else{
			setcookie('mensualite', 'echec', time()+3);
			header('location: mensualite.php');
		}
	}
}


include_once('vue/mensualite.php');