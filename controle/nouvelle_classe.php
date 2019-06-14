<?php
include_once('modele/connexion_base.php');
include_once('modele/nouvelle_classe.php');

if(isset($_POST['niveau']) && isset($_POST['libelle']) && isset($_POST['option']))
{
	$niveau=(int)$_POST['niveau'];
	$libelle=htmlspecialchars($_POST['libelle']);
	$option=htmlspecialchars($_POST['option']);
	
	$listeOption=['', 'SM', 'SE', 'SS'];
	
	if($niveau>=1 && $niveau<=13 && in_array($option, $listeOption))
	{
		$classe=['idEcole'=>$_SESSION['user']['idEcole'], 'niveau'=>$niveau, 'libelle'=>$libelle, 'option'=>$option];
		insertClasse($classe);
		
		setcookie('nouvelle_classe', 'ok', time()+3);
		header('location: nouvelle_classe.php');
	}
	else
	{
		setcookie('nouvelle_classe', 'bad', time()+3);
	}
}
else
{
	setcookie('nouvelle_classe', 'bad', time()+3);
}

include_once('vue/nouvelle_classe.php');