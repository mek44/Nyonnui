<?php
function getNoteEleve($idClasse, $idMatiere, $mois, $annee)
{
	global $base;
	
	$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee ORDER BY e.nom, e.prenom');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$annee,
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT valeur FROM note WHERE id_eleve=:id_eleve AND id_matiere=:id_matiere AND mois=:mois AND annee=:annee');
	for($i=0; $i<count($resultat); $i++)
	{
		$note=0;
		$prepare->execute([
				'id_eleve'=>$resultat[$i]['id'],
				'id_matiere'=>$idMatiere,
				'mois'=>$mois,
				'annee'=>$annee
			]);
		if($donnee=$prepare->fetch())
			$note=$donnee['valeur'];
		
		$resultat[$i]['note']=$note;
	}
	
	return $resultat;
}


function getClasse($idEcole)
{
    global $base;

    $prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
    $prepare->execute([$idEcole]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getMatiere($idClasse)
{
    global $base;

    $prepare=$base->prepare('SELECT id, nom FROM matiere WHERE id IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=?)');
    $prepare->execute([$idClasse]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getClasseEnseignant($user)
{
    global $base;

    $requete='';
    if($user['niveau']==='Primaire'){
        $requete='SELECT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_enseignant AS ce ON c.id=ce.id_classe WHERE ce.id_enseignant=?';
    }else{
        $requete='SELECT DISTINCT c.id, c.niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN classe_matiere_enseignant AS cm ON c.id=cm.id_classe WHERE cm.id_enseignant=?';
    }
        
    $prepare=$base->prepare($requete);
    $prepare->execute([$user['id']]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getMatiereEnseignant($user, $idClasse)
{
    global $base;

    $requete='';
    
    if($user['niveau']==='Primaire'){
        $requete='SELECT id, nom FROM matiere WHERE id IN(SELECT id_matiere FROM matiere_classe WHERE id_classe=:id_classe)';
    }else{
        $requete='SELECT m.id, m.nom FROM matiere AS m INNER JOIN classe_matiere_enseignant AS cm ON m.id=cm.id_matiere WHERE cm.id_classe=:id_classe AND cm.id_enseignant=:id_enseignant';
    }
    
    $prepare=$base->prepare($requete);
    $prepare->bindParam('id_classe', $idClasse);
    if($user['niveau']!=='Primaire'){
        $prepare->bindParam('id_enseignant', $user['id']);
    }
    $prepare->execute();
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}



if(isset($_GET['matricule']) && isset($_GET['note']) && isset($_GET['mois']) && isset($_GET['matiere']))
{
	session_start();
	$matricule=htmlspecialchars($_GET['matricule']);
	$note=floatval(str_replace(',', '.', $_GET['note']));
	$mois=(int)$_GET['mois'];
	$matiere=(int)$_GET['matiere'];
	
	if($mois>0 && $mois<13 && $matiere>0 && ($note>0 || $_GET['note']=='0') && isset($_SESSION['user']))
	{
		include_once('connexion_base.php');
		$prepare=$base->prepare('REPLACE INTO note(id_eleve, id_matiere, mois, valeur, annee) VALUES((SELECT id FROM eleve WHERE matricule=:matricule AND id_ecole=:id_ecole), :id_matiere, :mois, :valeur, :annee)');
		$prepare->execute([
				'matricule'=>$matricule,
				'id_ecole'=>$_SESSION['user']['idEcole'],
				'id_matiere'=>$matiere,
				'mois'=>$mois,
				'valeur'=>$note,
				'annee'=>$_SESSION['annee']
			]);
		echo 'enregistre';
	}
	else
		echo 'invalide';

}


if(isset($_GET['classe']))
{
	session_start();
	include_once('connexion_base.php');
	
	$classe=(int)$_GET['classe'];
	
	$prepare=$base->prepare('SELECT e.id, e.matricule, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee ORDER BY e.nom, e.prenom');
	$prepare->execute([
			'id_classe'=>$classe,
			'annee'=>$_SESSION['annee'],
		]);
	
	$eleve='<table class="table table-bordered table-striped table-condensed">
				<tr>
					<th>Matricule</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Note</th>
				</tr>';
						
	while($donnees=$prepare->fetch())
	{
		$eleve.='<tr class="eleve">
                        <td id="'.$donnees['matricule'].'">'.$donnees['matricule'].'</td>
                        <td>'.$donnees['nom'].'</td>
                        <td>'.$donnees['prenom'].'</td>
                        <td><input type="text" value="0" /></td>
                </tr>';
	}
	$eleve.='</table>';
	$prepare->closeCursor();
		
	$matiere='';
        if($_SESSION['user']['nom_fonction']==='Enseignant'){
            $listeMatiere= getMatiereEnseignant ($_SESSION['user'], $classe);
        }else{
            $listeMatiere= getMatiere ($classe);
        }
	
	foreach ($listeMatiere as $donnees)
	{
            $matiere.='<option value="'.$donnees['id'].'">'.$donnees['nom'].'</option>';
	}
	
	
	$resultat=['eleve'=>$eleve, 'matiere'=>$matiere];
	echo json_encode($resultat);
}