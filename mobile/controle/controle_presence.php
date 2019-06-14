<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/controle_presence.php');
include_once('../fonction.php');

function afficheEleve($listeEleve)
{
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


function afficherPeriode($periodes)
{
    $display='';
    foreach ($periodes as $periode)
    {
        $display.='<option>'.$periode['debut'].' - '.$periode['fin'].'</option>';
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

if(isset($_GET['nomFonction']) && isset($_GET['idEcole']) && isset($_GET['idConnecte']) && isset($_GET['niveau']))
{
    $idConnecte=(int)$_GET['idConnecte'];
    $idEcole=(int)$_GET['idEcole'];
    
    $mois=date('m');
    $annee=date('Y');
    $jour=date('d');

    $date=date('Y-m-d');

    if($_GET['nomFonction']==='Enseignant'){
        $listeClasse= getClasseEnseignant($idConnecte, $_GET['niveau']);
    }else{
        $listeClasse=getListeClasse($idEcole);
    }

    $listeEleve=[];
    $periodes=[];
    if(count($listeClasse)>0){
        $periodes=getPeriode($listeClasse[0]['id'], date('w'), getAnneeScolaire());
        $periode='';
        if(is_array($periodes) && count($periodes)>0){
            $periode=$periodes[0]['debut'].' - '.$periodes[0]['fin'];
        }
        $listeEleve=getListeEleve($listeClasse[0]['id'], getAnneeScolaire(), $date, $periode);
    }
    
    $displayEleve= afficheEleve($listeEleve);
    $displayClasse= afficherClasse($listeClasse);
    $displayPeriode= afficherPeriode($periodes);
    
    $reponse=['classe'=>$displayClasse, 'periode'=>$displayPeriode, 'eleve'=>$displayEleve];
    echo json_encode($reponse);
}


if(isset($_POST['id']) && isset($_POST['motif']) && isset($_POST['jour']) && isset($_POST['mois']) &&isset($_POST['annee']) && $_POST['periode'] && isset($_POST['present']))
{
    $date=$_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'];
    $present=(int)$_POST['present'];
    $periode= htmlspecialchars($_POST['periode']);

    $id=(int)$_POST['id'];
    controle($id, $date, $periode, $present, $_POST['motif'], getAnneeScolaire());
    
    echo 'fait';
}


if(isset($_GET['classe']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && !isset($_GET['periode']))
{
    $classe=(int)$_GET['classe'];
    $date=$_GET['annee'].'-'.$_GET['mois'].'-'.$_GET['jour'];
    $jour=(int)$_GET['jour'];
    $mois=(int)$_GET['mois'];
    $annee=(int)$_GET['annee'];

    $numeroJour=date('w', mktime(0, 0, 0, $mois, $jour, $annee));

    $anneeScolaire= getAnneeScolaire();

    $periodes= getPeriode($classe, $numeroJour, $anneeScolaire);
    $displayPeriode= afficherPeriode($periodes);

    $periode='';
    if(is_array($periodes) && count($periodes)>0){
        $periode=$periodes[0]['debut'].' - '.$periodes[0]['fin'];
    }

    $listeEleve=getListeEleve($classe, getAnneeScolaire(), $date, $periode);
    $displayEleve= afficheEleve($listeEleve);

    $reponse=['eleves'=> $displayEleve, 'periode'=>$displayPeriode];
    echo json_encode($reponse);
}


if(isset($_GET['classe']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['periode']))
{
    $classe=(int)$_GET['classe'];
    $date=$_GET['annee'].'-'.$_GET['mois'].'-'.$_GET['jour'];

    $listeEleve=getListeEleve($classe, getAnneeScolaire(), $date, $_GET['periode']);

    $displayEleve= afficheEleve($listeEleve);
    echo $displayEleve;
}
