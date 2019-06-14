<?php
function getRegion()
{
	global $base;
	
	$prepare=$base->query('SELECT id, nom FROM region ORDER BY nom');
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}

function getPrefecture($region=null)
{
	global $base;
	
	$requete='SELECT p.id, p.nom, r.nom AS nom_region FROM prefecture AS p INNER JOIN region AS r ON r.id=p.id_region ';
	if($region!=null)
		$requete.='AND p.id_region=:id_region ';
	
	$requete.='ORDER BY nom';
	
	$prepare=$base->prepare($requete);
	
	if($region!=null)
		$prepare->bindParam(':id_region', $region);
	
	$prepare->execute();
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}


function affichePrefecture($id)
{
	if($id==0)
		$listePrefecture=getPrefecture();
	else
		$listePrefecture=getPrefecture($id);
	
	$code='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Nom</th>
					<th>Région</th>
				</tr>';
								
								
	foreach($listePrefecture as $prefecture)
	{
		$code.='<tr class="prefecture" id="'.$prefecture['id'].'">
			<td style="width: 30%">'.$prefecture['nom'].'</td>
			<td>'.$prefecture['nom_region'].'</td>
		</tr>';
	}
								
	$code.='</table>';
	
	echo $code;
}

if(isset($_GET['id']))
{
	include_once('connexion_base.php');
	
	$id=(int)$_GET['id'];
	affichePrefecture($id);
}


if(isset($_POST['id_prefecture']) && isset($_POST['nom']) && isset($_POST['region']))
{
	include_once('connexion_base.php');
	
	$id=(int)$_POST['id_prefecture'];
	$region=(int)$_POST['region'];
	$nom=htmlspecialchars($_POST['nom']);
	
	$prepare=$base->prepare('UPDATE prefecture SET nom=:nom, id_region=:id_region WHERE id=:id');
	$prepare->execute([
			'nom'=>$nom,
			'id_region'=>$region,
			'id'=>$id
		]);
	
	$id=(int)$_GET['id'];
	
	affichePrefecture($id);
}