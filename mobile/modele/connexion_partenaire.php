<?php
function connexionPartenaire($login, $passe)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare("SELECT COUNT(*) AS nombre FROM utilisateur WHERE login=:login AND passe=:passe 
		AND id_fonction=(SELECT id FROM fonction WHERE nom='Partenaire')");
	$prepare->execute([
			'login'=>$login,
			'passe'=>$passe
		]);
	
	if($resultat=$prepare->fetch())
		$nombre=$resultat['nombre'];
	
	if($nombre>0)
		return true;
	else
		return false;
}


function getInformation($login)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare('SELECT u.id, u.id_ecole AS idEcole, u.nom, u.id_region AS idRegion, u.id_prefecture AS idPrefecture, u.login, u.id_fonction AS idFonction, f.nom AS nomFonction FROM utilisateur AS u INNER JOIN fonction AS f ON f.id=u.id_fonction WHERE u.login=?');
    $prepare->execute([$login]);

    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}