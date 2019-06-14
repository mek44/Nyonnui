<?php
function isMatriculeExist($matricule)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM personnel_gov WHERE matricule=:matricule');
	$prepare->execute(array(
		'matricule'=>$matricule)
            );
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	if($resultat['nombre']<1)
		return false;
	else
		return true;
}



function insertPersonnel(array $personnel)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO personnel_gov(matricule, cin, nom, prenom, sexe, date_naissance, lieu_naissance, adresse, email, telephone, personne_contact, telephone_contact,
                categorie, commune, titre_responsabilite) VALUES(:matricule, :cin, :nom, :prenom, :sexe, :date_naissance, 
		:lieu_naissance, :adresse, :email, :telephone, :personne_contact, :telephone_contact, :categorie, :commune, :responsabilite)');
	$prepare->execute([
            'matricule'=>$personnel['matricule'],
            'cin'=>$personnel['cin'],
            'nom'=>$personnel['nom'],
            'prenom'=>$personnel['prenom'],
            'sexe'=>$personnel['sexe'],
            'date_naissance'=>$personnel['date_naissance'],
            'lieu_naissance'=>$personnel['lieu_naissance'],
            'adresse'=>$personnel['adresse'],
            'email'=>$personnel['email'],
            'telephone'=>$personnel['telephone'],
            'personne_contact'=>$personnel['personneContact'],
            'telephone_contact'=>$personnel['telephoneContact'],
            'categorie'=>$personnel['categorie'],
            'commune'=>$personnel['commune'],
            'responsabilite'=>$personnel['responsabilite'],
        ]);
}




function getPrefecture($idRegion)
{
	global $base;

	$prepare=$base->prepare('SELECT id, nom FROM prefecture WHERE id_region=? ORDER BY nom');
	$prepare->execute([$idRegion]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}
