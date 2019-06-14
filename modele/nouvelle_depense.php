<?php
function ajouterDepense($categorie, $beneficiaire, $montant, $date, $idEcole, $annee)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO depense(date, id_depense, montant, beneficiaire, id_ecole, annee) VALUES(:date, :id_depense, :montant, :beneficiaire, :id_ecole, :annee)');
	$prepare->execute([
            'date'=>$date,
            'id_depense'=>$categorie,
            'montant'=>$montant,
            'beneficiaire'=>$beneficiaire,
            'id_ecole'=>$idEcole,
            'annee'=>$annee
        ]);
}


function getCategorie($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT id, libelle FROM categorie_depense WHERE id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

