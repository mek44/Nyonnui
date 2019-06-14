<?php
header('Access-Control-Allow-Origin: *');

include_once('../../modele/connexion_base.php');
include_once('../modele/saisie_note.php');
include_once('../fonction.php');

function afficherMatiere($listeMatiere)
{
    $display='';
    foreach($listeMatiere as $matiere)
    {
        $display.='<option value="'.$matiere['id'].'">'.$matiere['nom'].'</option>';
    }
    
    return $display;
}

function afficherClasse($listeClasse)
{
    $display='';
    
    foreach($listeClasse as $classe)
    {
           
        $display.='<option value="'.$classe['id'].'">'.formatClasse($classe).'</option>';
    }
    
    return $display;
							
}


function afficherEleve($listeEleve)
{
    $display='<table class="table table-bordered table-striped table-condensed">
        <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Note</th>
        </tr>';

    
    foreach($listeEleve as $eleve)
    {
        $display.='<tr class="eleve">
                <td id="'.$eleve['matricule'].'">'.$eleve['matricule'].'</td>
                <td>'.$eleve['nom'].'</td>
                <td>'.$eleve['prenom'].'</td>
                <td><input type="text" value="'.str_replace('.', ',', $eleve['note']).'" /></td>
        </tr>';
    }
    $display.='</table>';
    
    return $display;
}

function afficherMois($listeMois)
{
    $display='';
    foreach($listeMois as $cle=>$valeur)
    {
        $display.='<option value="'.$valeur.'">'.$cle.'</option>';
    }
    
    return $display;						
}


if(isset($_GET['idEcole']) && isset($_GET['nomFonction']) && isset($_GET['idConnecte']) && isset($_GET['niveau']))
{
    $idEcole=(int)$_GET['idEcole'];
    $idConnecte=(int)$_GET['idConnecte'];
    
    if($_GET['nomFonction']!=='Enseignant'){
        $listeClasse=getClasse($idEcole);
        $listeMatiere=getMatiere($listeClasse[0]['id']);
    }else{
        $listeClasse= getClasseEnseignant($idConnecte, $_GET['niveau']);
        $listeMatiere= getMatiereEnseignant($idConnecte, $_GET['niveau'], $listeClasse[0]['id']);
    }

    $listeEleve=getNoteEleve($listeClasse[0]['id'], $listeMatiere[0]['id'], 1, getAnneeScolaire());
    $listeMois=['Janvier'=>1, 'Février'=>2, 'Mars'=>3, 'Avril'=>4, 'Mai'=>5, 'Juin'=>6, 'Juillet'=>7, 'Août'=>8, 'Septembre'=>9, 'Octombre'=>10, 'Novembre'=>11, 'Décembre'=>12];

    $displayEleve= afficherEleve($listeEleve);
    $displayMatiere= afficherMatiere($listeMatiere);
    $displayMois= afficherMois($listeMois);
    $displayClasse= afficherClasse($listeClasse);
    
    $reponse=['eleve'=>$displayEleve, 'matiere'=>$displayMatiere, 'classe'=>$displayClasse, 'mois'=>$displayMois];
    echo json_encode($reponse);
}

if(isset($_GET['idEcole']) && isset($_GET['matricule']) && isset($_GET['mois']) && isset($_GET['matiere']) && !isset($_GET['note']))
{
    $matricule=htmlspecialchars($_GET['matricule']);
    $mois=(int)$_GET['mois'];
    $matiere=(int)$_GET['matiere'];
    $idEcole=(int)$_GET['idEcole'];

    $note=getNote($idEcole, $matricule, $matiere, $mois, getAnneeScolaire());
    
    echo $note;
}

if(isset($_GET['matricule']) && isset($_GET['note']) && isset($_GET['mois']) && isset($_GET['matiere']) && isset($_GET['idEcole']))
{
    $matricule=htmlspecialchars($_GET['matricule']);
    $note=floatval(str_replace(',', '.', $_GET['note']));
    $mois=(int)$_GET['mois'];
    $matiere=(int)$_GET['matiere'];
    $idEcole=(int)$_GET['idEcole'];

    if($mois>0 && $mois<13 && $matiere>0 && ($note>0 || $_GET['note']=='0'))
    {	
        insertNote($idEcole, $matricule, $matiere, $mois, $note, getAnneeScolaire());
        echo 'enregistre';
    }
    else
        echo 'invalide';

}


if(isset($_GET['classe']) && isset($_GET['nomFonction']) && isset($_GET['idConnecte']) && isset($_GET['niveau']))
{
	
    $classe=(int)$_GET['classe'];
    $idConnecte=(int)$_GET['idConnecte'];

    $listeEleve= getEleve($classe, getAnneeScolaire());
    $displayEleve= afficherEleve($listeEleve);


    if($_GET['nomFonction']==='Enseignant'){
        $listeMatiere= getMatiereEnseignant ($idConnecte, $_GET['niveau'], $classe);
    }else{
        $listeMatiere= getMatiere ($classe);
    }

    $displayMatiere= afficherMatiere($listeMatiere);

    $resultat=['eleve'=>$displayEleve, 'matiere'=>$displayMatiere];
    echo json_encode($resultat);
}