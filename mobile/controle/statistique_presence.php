<?php
header('Access-Control-Allow-Origin: *');
include_once('../../modele/connexion_base.php');
include_once('../modele/statistique_presence.php');
include_once ('../fonction.php');

function afficherStatistique($statistique, $nomFonction, $classeEnseignant)
{
    $code='';
    foreach($statistique as $classe)
    {
        if($nomFonction=='Enseignant' && !in_array($classe['id'], $classeEnseignant)){
            continue;
        }
        
        $code.='<div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                            <h1 class="panel-title">'. formatClasse($classe) .'</h1>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Effectif: <span class="badge succes">'.$classe['effectif'].'</span></li>
                            <li class="list-group-item">Garçons: <span class="badge succes">'.$classe['garcon'].'</span></li>
                            <li class="list-group-item">Filles: <span class="badge succes">'.$classe['fille'].'</span></li>
                        </ul>

                        <ul class="list-group">
                            <li class="list-group-item">Présent(s): <span class="badge succes">'.($classe['effectif']-$classe['absent']).'</span></li>
                            <li class="list-group-item">Absent(s): <span class="badge succes">'.$classe['absent'].'</span></li>
                            <li class="list-group-item">Fille(s) Absente(s): <span class="badge succes">'.$classe['fille_absent'].'</span></li>
                            <li class="list-group-item">Garçon(s) Absent(s): <span class="badge succes">'.($classe['absent']-$classe['fille_absent']).'</span></li>
                        </ul>

                        <p><button class="btn btn-success btn-block afficherAbsent" id="'.$classe['id'].'">Afficher les absents</button></p>
                    </div>
                </div>
        </div>';
    }

    return $code;
}

if(isset($_GET['nomFonction']) && isset($_GET['idEcole']) && isset($_GET['idConnecte']) && isset($_GET['niveau']) && !isset($_GET['jour']) && !isset($_GET['mois']) && !isset($_GET['annee']))
{
    $mois=date('m');
    $annee=date('Y');
    $jour=date('d');

    $date=date('Y-m-d');

    $ok=true;

    $titre='Statistique de présence ';
    $idEcole=(int)$_GET['idEcole'];
    $id=(int)$_GET['idConnecte'];

    if($_GET['nomFonction']!='Directeur général' && $_GET['nomFonction']!='Proviseur' && $_GET['nomFonction']!='Principal' && 
            $_GET['nomFonction']!='Directeur' && $_GET['nomFonction']!='Enseignant')
    {  
        $titre.=' de l\'établissement <br />'.getEcole($idEcole);
    }


    $classeEnseignant=[];
    if($_GET['nomFonction']=='Enseignant'){
        $classeEnseignant=getClasseEnseignant($id, $_GET['niveau']);
    }

    $statistique=getStatistique($idEcole, getAnneeScolaire(), $date);	
    $displayClasse= afficherStatistique($statistique, $_GET['nomFonction'], $classeEnseignant);
    
    echo json_encode(['classe'=>$displayClasse, 'titre'=>$titre]);
}


if(isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']) && isset($_GET['idEcole']) && isset($_GET['idConnecte']) && isset($_GET['nomFonction']))
{
    $jour=(int)$_GET['jour'];
    $mois=(int)$_GET['mois'];
    $annee=(int)$_GET['annee'];
    $idEcole=(int)$_GET['idEcole'];
    $id=(int)$_GET['idConnecte'];

    if(checkdate($mois, $jour, $annee))
    {
        $date=$annee.'-'.$mois.'-'.$jour;
    }
    else
    {
        $date=date('Y-m-d');
    }

    $classeEnseignant=[];
    if($_GET['nomFonction']=='Enseignant'){
        $classeEnseignant=getClasseEnseignant($id);
    }

    $statistique=getStatistique($idEcole, getAnneeScolaire(), $date);	
    $displayClasse= afficherStatistique($statistique, $_GET['nomFonction'], $classeEnseignant);
    
    echo $displayClasse;
}


if(isset($_GET['idClasse']) && isset($_GET['jour']) && isset($_GET['mois']) && isset($_GET['annee']))
{
    $idClasse=(int)$_GET['idClasse'];
    $jour=(int)$_GET['jour'];
    $mois=(int)$_GET['mois'];
    $annee=(int)$_GET['annee'];

    if(checkdate($mois, $jour, $annee))
    {	
        $date=$annee.'-'.$mois.'-'.$jour;
    }	
    else
    {
        $date=date('Y-m-d');
    }


    $absent= getAbsent($date, getAnneeScolaire(), $idClasse);

    $liste='<div class="table-responsive">
                <table class="table table-condensed table-bordered">
                    <tr>
                            <th style="width: 15%">Nom</th>
                            <th style="width: 30%">Prénom</th>
                            <th style="width: 50%">Motif</th>
                    </tr>';

    foreach ($absent as $eleve)
    {
        $liste.='<tr>
                <td>'.$eleve['nom'].'</td>
                <td>'.$eleve['prenom'].'</td>
                <td>'.$eleve['motif'].'</td>
        </tr>';
    }

    $liste.='</table>';

    $classe= getInfoClasse($idClasse);
    $displayClasse='Liste des absents de la '.formatClasse($classe);

    $displayClasse.=' '.$jour.'/'.$mois.'/'.$annee;
    echo json_encode(['liste'=>$liste, 'titre'=>$displayClasse]);
}