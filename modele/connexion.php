<?php
function connexionAdminComptable($login, $passe)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare("SELECT COUNT(*) AS nombre FROM utilisateur WHERE login=:login AND passe=:passe 
		AND id_fonction IN (SELECT id FROM fonction WHERE nom!='Partenaire')");
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

function connexionPartenaire($login, $passe)
{
	global $base;
	$nombre=0;
	
	$prepare=$base->prepare("SELECT COUNT(*) AS nombre FROM utilisateur WHERE login=:login AND passe=:passe 
		AND id_fonction IN (SELECT id FROM fonction WHERE nom IN('Partenaire', 'DRH'))");
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


function connexionEnseignant($matricule, $passe, $idEcole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM personnel WHERE matricule=:matricule AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                    'matricule'=>$matricule,
                    'passe'=>$passe,
                    'id_ecole'=>$idEcole
            ]);

    if($resultat=$prepare->fetch())
        $nombre=$resultat['nombre'];

    if($nombre>0){
        return true;
    }else{
        return false;
    }
}


function connexionEleve($matricule, $passe, $idEcole)
{
    global $base;
    try{
    $nombre=0;
    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM eleve WHERE matricule=:matricule AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                'matricule'=>$matricule,
                'passe'=>$passe,
                'id_ecole'=>$idEcole
            ]);

    if(($resultat=$prepare->fetch())){
        $nombre=$resultat['nombre'];
    }
    
    if($nombre>0){
        return true;
    }
    else{
        return false;
    }
    }catch(Exception $e){
        die($e->getMessage());
    }
}



function connexionParent($telephone, $passe, $idEcole)
{
    global $base;
    $nombre=0;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM tuteur WHERE telephone=:telephone AND passe=:passe AND id_ecole=:id_ecole');
    $prepare->execute([
                'telephone'=>$telephone,
                'passe'=>$passe,
                'id_ecole'=>$idEcole
            ]);

    if(($resultat=$prepare->fetch())){
        $nombre=$resultat['nombre'];
    }
    
    if($nombre>0){
        return true;
    }else{
        return false;
    }
}


function getInformation($login)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare('SELECT u.id, u.id_ecole AS idEcole, u.nom, u.id_region, u.id_prefecture, u.login, u.id_fonction, f.nom AS nom_fonction
            FROM utilisateur AS u INNER JOIN fonction AS f ON f.id=u.id_fonction WHERE u.login=?');
    $prepare->execute([$login]);

    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}


function getInformationEnseignant($matricule, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, nom, 'Enseignant' AS nom_fonction, niveau FROM personnel WHERE matricule=:matricule AND id_ecole=:id_ecole");
    $prepare->execute([
        'matricule'=>$matricule,
        'id_ecole'=>$idEcole
    ]);
    
    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}


function getInformationEleve($matricule, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, nom, prenom, 'Eleve' AS nom_fonction FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole");
    $prepare->execute([
        'matricule'=>$matricule,
        'id_ecole'=>$idEcole
    ]);
    
    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}


function getInformationParent($telephone, $idEcole)
{
    global $base;
    
    $user=[];

    $prepare=$base->prepare("SELECT id, id_ecole AS idEcole, nom, 'Parent' AS nom_fonction FROM tuteur WHERE telephone=:telephone AND id_ecole=:id_ecole");
    $prepare->execute([
        'telephone'=>$telephone,
        'id_ecole'=>$idEcole
    ]);
    
    if(($resultat=$prepare->fetch())){
        $user=$resultat;
    }
    
    return $user;
}



