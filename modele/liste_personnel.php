<?php
function getListePersonnel($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT matricule, nom, prenom, sexe, lieu_naissance, DATE_FORMAT(date_naissance, \'%d-%m-%Y\') AS date_naissance, niveau FROM personnel WHERE id_ecole=?');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	return $resultat;
}


function getNiveauPrimaire($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=? AND niveau<7 ORDER BY niveau');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getNiveauSecondaire($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=? AND niveau>=7 ORDER BY niveau');
	$prepare->execute([$idEcole]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}

function getMatiereClasse($idClasse)
{
	global $base;
	
	$prepare=$base->prepare('SELECT m.id, m.nom FROM matiere AS m INNER JOIN matiere_classe AS mc ON m.id=mc.id_matiere WHERE mc.id_classe=?');
	$prepare->execute([$idClasse]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	return $resultat;
}


if(isset($_POST['cycle']) && isset($_POST['matricule']) && isset($_POST['classe']))
{
    include_once('connexion_base.php');
    
    $cycle= htmlspecialchars($_POST['cycle']);
    $matricule= htmlspecialchars($_POST['matricule']);
    $classe=(int)$_POST['classe'];
    
    if($cycle==='Primaire')
    {
        $prepare=$base->prepare('INSERT INTO classe_enseignant(id_enseignant, id_classe) VALUES((SELECT id FROM personnel WHERE matricule=:matricule), :classe)');
        $prepare->execute([
            'matricule'=>$matricule,
            'classe'=>$classe
        ]); 
    }else if($cycle==='Secondaire' && isset ($_POST['matiere'])){
        $matiere=(int)$_POST['matiere'];
        $prepare=$base->prepare('REPLACE INTO classe_matiere_enseignant(id_enseignant, id_classe, id_matiere) VALUES((SELECT id FROM personnel WHERE matricule=:matricule), :classe, :matiere)');
        $prepare->execute([
            'matricule'=>$matricule,
            'classe'=>$classe,
            'matiere'=>$matiere
        ]);
    }
    
    $prepare=$base->prepare("UPDATE personnel SET niveau=:niveau WHERE matricule=:matricule");
    $prepare->execute([
        'niveau'=>$cycle,
        'matricule'=>$matricule
    ]);
    
    echo 'Enregistrement effectué';
}


if(isset($_GET['classe']))
{
    include_once('connexion_base.php');
    $classe=(int)$_GET['classe'];
    
    $listeMatiere=getMatiereClasse($classe);
    $table='<table class="table table-bordered table-striped table-condensed">
        <tr>
            <th>Matière</th>
            <th>Ajouter</th>
        </tr>';

  
    foreach($listeMatiere as $matiere)
    {
        $table.='<tr id="'.$matiere['id'].'" class="matiere">
                    <td>'.$matiere['nom'].'</td>
                    <td><input type="checkbox" /></td>
            </tr>';
    }
    
    $table.='</table>';
    
    echo $table;
}
    
if(isset($_GET['matricule']) && isset($_GET['niveau']))
{
	include_once('connexion_base.php');
        include_once('../fonction.php');
	
	$matricule=htmlspecialchars($_GET['matricule']);
        $niveau=htmlspecialchars($_GET['niveau']);
	
	$prepare=$base->prepare('SELECT matricule, nom, prenom, sexe, lieu_naissance, DATE_FORMAT(date_naissance, \'%d-%m-%Y\') AS date_naissance, 
		telephone, quartier, fonction, photo, salaire_base, taux_horaire, DATE_FORMAT(date_engagement, \'%d-%m-%Y\') AS date_engagement 
		FROM personnel WHERE matricule=?');
	$prepare->execute([$matricule]);
	$resultat=$prepare->fetch();
	$prepare->closeCursor();
        
        if($niveau==='Primaire'){
            $prepare=$base->prepare('SELECT id_classe FROM classe_enseignant WHERE id_enseignant=(SELECT id FROM personnel WHERE matricule=:matricule)');
            $prepare->execute(['matricule'=>$matricule]);
            $classe=$prepare->fetch();
            $classe=$classe['id_classe'];
            $prepare->closeCursor();
        }else {
            $prepare=$base->prepare('SELECT cm.id_classe, cm.id_matiere, c.niveau, c.option_lycee, c.intitule, m.nom FROM classe_matiere_enseignant AS cm INNER JOIN classe AS c 
                    ON c.id=cm.id_classe INNER JOIN matiere AS m ON m.id=cm.id_matiere WHERE cm.id_enseignant=(SELECT id FROM personnel WHERE matricule=:matricule)');
            $prepare->execute(['matricule'=>$matricule]);
            $classeMatieres=$prepare->fetchAll();
            $prepare->closeCursor();
            
            $classe='';
            foreach ($classeMatieres as $classeMatiere){
                $classe.='<tr class="matiereClasse"><td id="'.$classeMatiere['id_classe'].'">'.formatClasse($classeMatiere).'</td><td id="'.$classeMatiere['id_matiere'].'">'.$classeMatiere['nom'].'</td></tr>';
            }
        }
        
        $resultat['classe']=$classe;
	
	echo json_encode($resultat);
}