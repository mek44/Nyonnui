<?php
header('Access-Control-Allow-Origin: *');

$information['connexion']='false';
include_once('../../modele/connexion_base.php');
include_once('../modele/connexion_parent_eleve.php');

if(isset($_POST['matricule']) && isset($_POST['passe']) && isset($_POST['ecole']) && isset($_POST['parent_eleve']))
{
    if($_POST['parent_eleve']=='parent')
    {
        if(connexionParent($_POST['matricule'], sha1($_POST['passe']), $_POST['ecole'])){
            $information=getInformationParent($_POST['matricule'], $_POST['ecole']);
            $information['connexion']='true';

            $mois=date('m');
            $annee=date('Y');

            if($mois>=9)
                $_SESSION['annee']=$annee.'-'.($annee+1);
            else
                $_SESSION['annee']=($annee-1).'-'.$annee;
        }
    }
    else 
    {
        if(connexionEleve($_POST['matricule'], sha1($_POST['passe']), $_POST['ecole']))
        {
            $information=getInformationEleve($_POST['matricule'], $_POST['ecole']);
            $information['connexion']='true';

            $mois=date('m');
            $annee=date('Y');

            if($mois>=9){
                setcookie('annee', $annee.'-'.($annee+1), time()+3600*30);
            }else{
                setcookie('annee', ($annee-1).'-'.$annee, time()+3600*30);
            }
        }
    }


    echo json_encode($information);
}

if(isset($_GET['option']))
{
	$listeEcole=getEcole();
	$code='';
	foreach ($listeEcole as $ecole) {
		$code.='<option value="'.$ecole['id'].'">'.$ecole['nom'].'</option>';
	}

	echo $code;
}