<?php
function getEtat($date, $idEcole, $annee)
{
	global $base;
	
	$prepare=$base->prepare("SELECT e.id, e.nom, e.prenom, e.matricule, c.niveau, c.intitule, c.option_lycee, SUM(s.montant) AS montant FROM eleve AS e INNER JOIN classe_eleve AS ce ON e.id=ce.id_eleve"
                . " INNER JOIN classe AS c ON c.id=ce.id_classe INNER JOIN scolarite AS s ON e.id=s.id_eleve WHERE e.id_ecole=:ecole AND s.date=:date AND ce.annee=:annee GROUP BY s.id_eleve ORDER BY nom, prenom");
	
	$prepare->execute([
            'ecole'=>$idEcole,
            'date'=>$date,
            'annee'=>$annee
        ]);
		
	$resultat=$prepare->fetchAll();
	$prepare->closeCursor();
        
        $listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];
        $prepare=$base->prepare('SELECT COUNT(*) AS nombre FROM scolarite WHERE mois=:mois AND date=:date AND id_eleve=:eleve');
        for($i=0; $i<count($resultat); $i++)
        {
            foreach($listeMois as $mois)
            {
                $prepare->execute([
                    'mois'=>$mois,
                    'date'=>$date,
                    'eleve'=>$resultat[$i]['id']
                ]);
                
                $reponse=$prepare->fetch();
                $prepare->closeCursor();
                $payer=false;
                
                if($reponse['nombre']>0)
                    $payer=true;
                
                $resultat[$i]['mois'.$mois]=$payer;
            }
        }
        
	return $resultat;
}





if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']))
{
	session_start();
	include_once('connexion_base.php');
        include_once ('../fonction.php');
	$jour=(int)$_GET['jour'];
	$mois=(int)$_GET['mois'];
	$annee=(int)$_GET['annee'];
	
        $listeMois=[9, 10, 11, 12, 1, 2, 3, 4, 5];
	$date=$annee.'-'.$mois.'-'.$jour;
        
        $etats=getEtat($date, $_SESSION['user']['idEcole'], $_SESSION['annee']);
	
	$display='<table class="table table-bordered table-striped table-condensed">
                        <tr class="entete-table">
                            <th rowspan="2">Matricule</th>
                            <th rowspan="2">Prénoms et Nom</th>
                            <th rowspan="2">Classe</th>
                            <th rowspan="2">Montant</th>
                            <th colspan="9">Mois</th>
                        </tr>

                        <tr class="entete-table">
                            <th>S</th>
                            <th>O</th>
                            <th>N</th>
                            <th>D</th>
                            <th>J</th>
                            <th>F</th>
                            <th>M</th>
                            <th>A</th>
                            <th>M</th>
                        </tr>';

                                        
        foreach($etats as $etat)
        {
            $display.='<tr>
                <td>'.$etat['matricule'].'</td>
                <td>'.$etat['prenom'].' '.$etat['nom'].'</td>
                <td>'.formatClasse($etat).'</td>
                <td>'.formatageMontant($etat['montant']).'</td>';
                
                foreach ($listeMois as $mois)
                {
                $display.='<td>'.($etat['mois'.$mois]?'x':'').'</td>';
                }
                
            $display.='</tr>';
        }
        
	
	$display.='</table>';
	
	echo $display;
}