<?php
header('Access-Control-Allow-Origin: *');
include_once ('../../modele/connexion_base.php');
include_once('../modele/enfants_tuteur.php');
include_once ('../fonction.php');

if(isset($_GET['idTuteur']))
{
    $id=(int)$_GET['idTuteur'];
    $listeEnfants=getEnfants($id, getAnneeScolaire());
    $display='<table class="table table-bordered table-striped table-condensed">
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th></th>
                </tr>';

    foreach($listeEnfants as $enfants)
    {
        $display.='<tr>
                <td>'.$enfants['matricule'].'</td>
                <td>'.$enfants['nom'].'</td>
                <td>'.$enfants['prenom'].'</td>
                <td>'.formatClasse($enfants).'</td>
                <td><a href="bulletin.html" id="bulletin-'.$enfants['id'].'" class="bulletin">bulletin</a></td>
                <td><a href="mensualite_tuteur.html" id="mensualite-'.$enfants['id'].'" class="mensualite">Mensualité</a></td>
        </tr>';
    }
    
    $display.='</table>';
    
    
    echo $display;
}

