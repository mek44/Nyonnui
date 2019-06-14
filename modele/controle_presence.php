<?php
function getListeClasse($idEcole)
{
	global $base;
	
	$prepare=$base->prepare('SELECT c.id, n.Libelle as niveau, c.intitule, c.option_lycee FROM classe AS c INNER JOIN niveau as n on c.niveau=n.Niveau WHERE c.id_ecole=?');
	$prepare->execute([$idEcole]);
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


function getPeriode($idClasse, $jour, $annee)
{
    global $base;
    
    $prepare=$base->prepare("SELECT DATE_FORMAT(debut, '%H:%i') AS debut, DATE_FORMAT(fin, '%H:%i') AS fin FROM emploie WHERE id_classe=:classe AND jour=:jour AND annee=:annee");
    $prepare->execute([
        'classe'=>$idClasse,
        'jour'=>$jour,
        'annee'=>$annee
    ]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}


function getListeEleve($idClasse, $annee, $date, $periode)
{
	global $base;
	
	$prepare=$base->prepare('SELECT e.id, e.nom, e.prenom FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve 
		WHERE ce.id_classe=:id_classe AND ce.annee=:annee');
	$prepare->execute([
			'id_classe'=>$idClasse,
			'annee'=>$annee,
		]);
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
	
	$prepare=$base->prepare('SELECT present, motif FROM controle WHERE id_eleve=:id AND date=:date AND periode=:periode');
	for($i=0; $i<count($resultat); $i++)
	{
		$prepare->execute([
                    'id'=>$resultat[$i]['id'],
                    'date'=>$date,
                    'periode'=>$periode
		]);
		
		if(($donnee=$prepare->fetch()))
		{
			$resultat[$i]['motif']=$donnee['motif'];
			$resultat[$i]['present']=$donnee['present'];
		}
		else
		{
			$resultat[$i]['motif']='';
			$resultat[$i]['present']=1;
		}
	}
	$prepare->closeCursor();
	
	return $resultat;
}



function afficheEleve($classe, $annee, $date, $periode)
{
    $listeEleve=getListeEleve($classe, $annee, $date, $periode);
		
    $table='<table class="table table-condensed table-bordered">
                            <tr>
                                    <th style="width: 15%">Nom</th>
                                    <th style="width: 30%">Prénom</th>
                                    <th style="width: 5%">Présent</th>
                                    <th style="width: 50%">Motif</th>
                            </tr>';


    foreach ($listeEleve as $eleve)
    {
            $checked='';
            if($eleve['present'])
                    $checked='checked';

            $table.='<tr class="eleve" id="'.$eleve['id'].'">
                    <td>'.$eleve['nom'].'</td>
                    <td>'.$eleve['prenom'].'</td>
                    <td><input type="checkbox" '.$checked.' /></td>
                    <td><input type="text" name="motif" class="form-controle" style="width: 100%;" value="'.$eleve['motif'].'" /></td>
            </tr>';
    }

    $table.='</table>';
    
    return $table;
}

if(isset($_POST['id']) && isset($_POST['motif']) && isset($_POST['jour']) && isset($_POST['mois']) &&isset($_POST['annee']) && $_POST['periode'] && isset($_POST['present']))
{
	session_start();
	include_once('connexion_base.php');
	
	$date=$_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
	$present=(int)$_POST['present'];
        $periode= htmlspecialchars($_POST['periode']);
	
	$prepare=$base->prepare('REPLACE INTO controle(id_eleve, date, periode, present, motif, annee) VALUES(:id_eleve, :date, :periode, :present, :motif, :annee)');
	$prepare->execute([
			'id_eleve'=>$_POST['id'],
			'date'=>$date,
                        'periode'=>$periode,
			'present'=>$present,
			'motif'=>$_POST['motif'],
			'annee'=>$_SESSION['annee']
		]);
}


if(isset($_GET['classe']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && !isset($_GET['periode']))
{
	$classe=(int)$_GET['classe'];
	$date=$_GET['annee'].'-'.$_GET['mois'].'-'.$_GET['jour'];
        $jour=(int)$_GET['jour'];
        $mois=(int)$_GET['mois'];
        $annee=(int)$_GET['annee'];
        
        $numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));
	
	session_start();
	if(isset($_SESSION['annee']))
	{
		include_once('connexion_base.php');
		
                
                $periodes= getPeriode($classe, $numeroJour, $_SESSION['annee']);
                $listePeriode='';
                
                foreach ($periodes as $periode)
                {
                    $listePeriode.='<option>'.$periode['debut'].' - '.$periode['fin'].'</option>';
                }
                
                $periode='';
                if(is_array($periodes) && count($periodes)>0){
                    $periode=$periodes[0]['debut'].' - '.$periodes[0]['fin'];
                }
                
                
		$reponse=['eleves'=> afficheEleve($classe, $_SESSION['annee'], $date, $periode), 'periode'=>$listePeriode];
		echo json_encode($reponse);
	}
	
}


if(isset($_GET['classe']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['periode']))
{
	$classe=(int)$_GET['classe'];
	$date=$_GET['annee'].'-'.$_GET['mois'].'-'.$_GET['jour'];
        
	session_start();
	if(isset($_SESSION['annee']))
	{
            include_once('connexion_base.php');


            echo afficheEleve($classe, $_SESSION['annee'], $date, $_GET['periode']);
	}
	
}