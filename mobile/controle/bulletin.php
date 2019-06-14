<?php
header('Access-Control-Allow-Origin: *');

include_once('../../modele/connexion_base.php');
include_once('../modele/bulletin.php');
include_once('../fonction.php');

function afficherNote($trimestre, $niveau, $totalMois, $titre, $resultat, $observation, $nombreMois, $coefficientTotal, $moyenneGenerale, $moyenneTrimestre=null)
{
    $note='<table class="table table-bordered table-striped table-condensed"><tr>';
    foreach($titre as $element)
    {
        $note.='<th>'.$element.'</th>';
    }
    $note.='</tr>';

    $i=1;
        foreach($resultat as $matiere)
        {
            $note.='<tr class="eleve">
                    <td>'.$i.'</td>
                    <td>'.$matiere['nom'].'</td>';

            if($niveau>=7)
            {
                $note.='<td>'.$matiere['coefficient'].'</td>';
            }

            for($j=1; $j<=$nombreMois; $j++)
            {
                $note.='<td>'.parseReel($matiere['note'.$j]).'</td>';
            }							
            $note.='<td>'.parseReel($matiere['moyenne']).'</td>
                    <td>'.$matiere['observation'].'</td>
            </tr>';
            $i++;
        }

        $note.='<tr>
                <td></td>
                <td></td>';

        if($niveau>=7)
        {
                $note.='<td></td>';
        }

        foreach($totalMois as $element)
        {
            $note.='<td>'.parseReel($element/$coefficientTotal).'</td>';
        }

        $note.='<td>'.parseReel($moyenneGenerale).'</td>
                <td>'.$observation.'</td>
            </tr></table>';
    
    return $note;
}
if(isset($_GET['idEleve']) && !isset($_GET['annee']) && !isset($_GET['trimestre']))
{
    $idEleve=(int)$_GET['idEleve'];
    $trimestre=1;
    $information=getInformation($idEleve, getAnneeScolaire());
    $eleve=$information['eleve'];
    $classe= $information['classe'];
    $listeAnnee=getListeAnnee($idEleve);
    $bulletin=getBulletinTrimestre($idEleve, $trimestre, getAnneeScolaire());
    $rang=getRangTrimestre($idEleve, getAnneeScolaire(), $trimestre);
    $titre=$bulletin['titre'];
    $resultat=$bulletin['resultat'];
    $nombreMois=$bulletin['nombreMois'];
    $totalMois=$bulletin['totalMois'];	
    $niveau=$bulletin['niveau'];

    $coefficientTotal=$bulletin['coefficientTotal'];
    $moyenneGenerale=$bulletin['moyenneGenerale']/($nombreMois*$coefficientTotal);
    
    $observation=getObservation($classe['niveau'], $moyenneGenerale);
    $note=afficherNote($trimestre, $classe['niveau'], $totalMois, $titre, $resultat, $observation, $nombreMois, $coefficientTotal, $moyenneGenerale);
    
    $displayAnnee='';
    foreach($listeAnnee as $annee)
    {
        $displayAnnee.='<option value="'.$annee['annee'].'">'.$annee['annee'].'</option>';
    }
    
    $title='Bulletin de note ';
    if($trimestre==4)
        $title.='annuel';
    else
        $title.= formatClasse($information['classe']).' Trimestre '.$trimestre;
    
    $reponse=$eleve;
    $reponse['classe']=formatClasse($information['classe']);
    $reponse['annee']=$displayAnnee;
    $reponse['note']=$note;
    $reponse['titre']=$titre;
    $reponse['rang']=$rang;
    $reponse['moyenne']= parseReel($moyenneGenerale);
    $reponse['title']=$title;
    
    echo json_encode($reponse);
}




if(isset($_GET['annee']) && isset($_GET['trimestre']) && isset($_GET['idEleve']))
{
    $idEleve=(int)$_GET['idEleve'];
    $annee=$_GET['annee'];
    $trimestre=(int)$_GET['trimestre'];

    $information=getInformation($idEleve, $annee);
    $eleve=$information['eleve'];
    $classe=$information['classe'];
    if($trimestre!=4)
    {
        $bulletin=getBulletinTrimestre($idEleve, $trimestre, $annee);
        $rang=getRangTrimestre($idEleve, $annee, $trimestre);
        $titre=$bulletin['titre'];
        $resultat=$bulletin['resultat'];
        $nombreMois=$bulletin['nombreMois'];
        $totalMois=$bulletin['totalMois'];
        $coefficientTotal=$bulletin['coefficientTotal'];
        $moyenneGenerale=$bulletin['moyenneGenerale']/($coefficientTotal*$nombreMois);
        $niveau=$bulletin['niveau'];
        $moyenneTrimestre=[];
    }
    else
    {
        $bulletin=getBulletinAnnuel($idEleve, $annee);
        $rang=getRangAnnuel($idEleve, $annee);
        $titre=$bulletin['titre'];
        $resultat=$bulletin['resultat'];
        $coefficientTotal=$bulletin['coefficientTotal'];
        $moyenneGenerale=$bulletin['moyenneGenerale'];
        $moyenneTrimestre=$bulletin['moyenneTrimestre'];
        $niveau=$bulletin['niveau'];
    }

    $observation=getObservation($classe['niveau'], $moyenneGenerale);

    $note=afficherNote($trimestre, $classe['niveau'], $totalMois, $titre, $resultat, $observation, $nombreMois, $coefficientTotal, $moyenneGenerale, $moyenneTrimestre);

    $title='Bulletin de note ';
    if($trimestre==4)
        $title.='annuel';
    else
        $title.= formatClasse($classe).' Trimestre '.$trimestre;

   
    $reponse=['note'=>$note, 'title'=>$title, 'rang'=>$rang, 'moyenne'=>parseReel($moyenneGenerale)];
    echo json_encode($reponse);
}
