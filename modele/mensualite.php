<?php
function paiementMensualite($idEleve, $mois, $date, $libelle, $montant, $reduction, $recu)
{
	global $base;
	
	$prepare=$base->prepare('INSERT INTO scolarite(id_eleve, date, mois, libelle, montant, reduction, num_recus, annee) 
		VALUES(:id_eleve, :date, :mois, :libelle, :montant, :reduction, :recu, :annee)');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'mois'=>$mois,
			'date'=>$date,
                        'libelle'=>$libelle,
			'montant'=>$montant, 
			'reduction'=>$reduction,
			'recu'=>$recu,
			'annee'=>$_SESSION['annee']
		]);
}


function mensualitePaye($idEleve, $mois)
{
	global $base;
	
	$prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM scolarite WHERE id_eleve=:id_eleve AND mois=:mois AND annee=:annee');
	$prepare->execute([
			'id_eleve'=>$idEleve,
			'mois'=>$mois,
			'annee'=>$_SESSION['annee']
		]);
	
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	if($resultat['nombre']>0)
		return true;
	else
		return false;
}

/* ajouté par JPHN le 12/06/2019
 * permet de récupérer la liste des libellés représentant les différents types de frais de scolarité
 * à payer par les élèves
 */
function getFeeLabels($idEcole){
    
    global $base;
    $annee = $_SESSION['annne'];
    $prepare = $base->prepare('SELECT libelle FROM type_scolarite WHERE id_ecole=:idEcole GROUP BY libelle ORDER BY libelle');
    $prepare->execute([
        'idEcole'=>$idEcole
    ]);
    $resultat = $prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}
/* fin insertion JPHN */

function getInfo($idEleve, $annee)
{
	global $base;
	
	$prepare=$base->prepare('SELECT e.matricule, e.nom, e.prenom, c.niveau, c.intitule, c.option_lycee, ec.nom AS nom_ecole
			FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN ecole AS ec ON ec.id=e.id_ecole
			WHERE e.id=:id AND ce.annee=:annee');
	$prepare->execute([
            'id'=>$idEleve,
            'annee'=>$annee
        ]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
	
	return $resultat;
}


if(isset($_GET['matricule']))
{
	session_start();
	include_once('connexion_base.php');

	$prepare=$base->prepare('SELECT COUNT(ce.id_eleve) AS nombre FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE e.matricule=:matricule AND e.id_ecole=:id_ecole AND ce.annee=:annee');
	$prepare->execute([
			'matricule'=>$_GET['matricule'],
			'annee'=>$_SESSION['annee'],
			'id_ecole'=>$_SESSION['user']['idEcole']
		]);
	$nombre=$prepare->fetch();
	$prepare->closeCursor();
	
	if($nombre['nombre']<1)
	{
		echo json_encode($nombre);
	}
	else
	{
/*		$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom, e.sexe, e.photo, c.niveau, c.intitule, c.option_lycee
			FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe 
			WHERE e.matricule=:matricule AND e.id_ecole=:id_ecole AND ce.annee=:annee');
 */
		$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom, e.sexe, e.photo, n.Libelle as niveau, c.intitule, c.option_lycee
			FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN niveau AS n ON n.Niveau=c.niveau
			WHERE e.matricule=:matricule AND e.id_ecole=:id_ecole AND ce.annee=:annee');
		$prepare->execute([
				'matricule'=>$_GET['matricule'],
				'id_ecole'=>$_SESSION['user']['idEcole'],
				'annee'=>$_SESSION['annee']
			]);
		$resultat=$prepare->fetch();
		$prepare->closeCursor();
	
		echo json_encode($resultat);
	}
}
