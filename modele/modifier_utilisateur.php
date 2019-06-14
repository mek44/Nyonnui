<?php
if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['adresse']) && 
		!empty($_POST['adresse']) && isset($_POST['telephone']) && !empty($_POST['telephone']) && isset($_POST['login']) && !empty($_POST['login']) && 
		isset($_POST['fonction']) && !empty($_POST['fonction']) && isset($_POST['region']) && !empty($_POST['region']) && 
		isset($_POST['prefecture']) && !empty($_POST['prefecture']) && isset($_POST['ecole']) && !empty($_POST['ecole']))
{
	include_once('connexion_base.php');
	include_once('liste_utilisateur.php');
	session_start();
	
	$fonction=(int)$_POST['fonction'];
	$region=(int)$_POST['region'];
	$prefecture=(int)$_POST['prefecture'];
	
	updateUtilisateur($_POST['id'], $region, $prefecture, $_POST['ecole'], $_POST['nom'], $_POST['adresse'], 
		$_POST['telephone'], $_POST['login'], $fonction);
			
	if(isset($_POST['passe']) && !empty($_POST['passe']) && isset($_POST['confirmation']) && !empty($_POST['confirmation']) && 
	$_POST['passe']==$_POST['confirmation'] && isset($_POST['modifierPasse']))
	{
		updatePasse($_POST['id'], sha1($_POST['passe']));
	}
	
	$listeUtilisateur=getListeUtilisateur();
	
	$table='<table class="table table-bordered table-striped table-condensed">
			<tr>
				<th>Nom</th>
				<th>Adresse</th>
				<th>Téléphone</th>
				<th>Login</th>
				<th>Fonction</th>
				<th>Région</th>
				<th>Préfecture</th>
				<th>Ecole</th>
				
			</tr>';
			
	foreach($listeUtilisateur as $utilisateur)
	{
		$table.='<tr class="utilisateur" id="'.$utilisateur['id'].'">
			<td>'.$utilisateur['nom'].'</td>
			<td>'.$utilisateur['adresse'].'</td>
			<td>'.$utilisateur['telephone'].'</td>
			<td>'.$utilisateur['login'].'</td>
			<td>'.$utilisateur['nom_fonction'].'</td>
			<td>'.$utilisateur['nom_region'].'</td>
			<td>'.$utilisateur['nom_pref'].'</td>
			<td>'.$utilisateur['nom_ecole'].'</td>
		</tr>';
	}
		
	$table.='</table>';
	
	echo $table;
}