<?php
function getPersonnel($commune, $categorie)
{
    global $base;

    $prepare=$base->prepare("SELECT p.id, p.matricule, p.cin, p.nom, p.prenom, p.sexe, DATE_FORMAT(p.date_naissance, '%d-%m-%Y') AS date, p.lieu_naissance, p.adresse, p.telephone, 
        p.email, p.personne_contact, p.telephone_contact, p.categorie, p.titre_responsabilite, pr.nom AS nom_commune FROM personnel_gov AS p 
        INNER JOIN prefecture AS pr ON pr.id=p.commune WHERE p.commune=:commune AND p.categorie=:categorie ORDER BY p.nom, p.prenom");
    $prepare->execute([
            'commune'=>$commune,
            'categorie'=>$categorie
        ]);
    $resultat=$prepare->fetchAll();

    return $resultat;
}


function getPrefecture($idRegion)
{
    global $base;

    $prepare=$base->prepare('SELECT id, nom FROM prefecture WHERE id_region=? ORDER BY nom');
    $prepare->execute([$idRegion]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();

    return $resultat;
}


function getStatistique($commune)
{
    global $base;

    $prepare=$base->prepare('SELECT COUNT(*) AS nombre, categorie FROM personnel_gov WHERE commune=:commune GROUP BY categorie');
    $prepare->execute(['commune'=>$commune]);
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
    
    $prepare=$base->prepare("SELECT COUNT(sexe) AS fille FROM personnel_gov WHERE commune=:commune AND categorie=:categorie AND sexe='F'");
    for($i=0; $i<count($resultat); $i++)
    {
        $prepare->execute([
            'commune'=>$commune,
            'categorie'=>$resultat[$i]['categorie']
        ]);
        
        $reponse=$prepare->fetch();
        $resultat[$i]['fille']=$reponse['fille'];
        $prepare->closeCursor();
    }
   
    return $resultat;
}


function getCategories()
{
    global $base;

    $prepare=$base->query('SELECT DISTINCT categorie FROM personnel_gov');
    $resultat=$prepare->fetchAll();
    $prepare->closeCursor();
   
    return $resultat;
}


function statistiqueGlobale($idRegion)
{	
    global $base;
    
    $statistiques=getPrefecture($idRegion);
    $categories=getCategories();
    
    $prepare=$base->prepare("SELECT COUNT(*) AS nombre FROM personnel_gov WHERE commune=:commune AND categorie=:categorie");
    for($i=0; $i<count($statistiques); $i++)
    {
        foreach($categories as $categorie)
        {
            $prepare->execute([
                'commune'=>$statistiques[$i]['id'],
                'categorie'=>$categorie['categorie']
            ]);
            $reponse=$prepare->fetch();
            $statistiques[$i][$categorie['categorie']]=$reponse['nombre'];
            $prepare->closeCursor();
        }   
    }
    
    return $statistiques;
}



if(isset($_GET['prefecture']) && isset($_GET['categorie']))
{
    include_once ('connexion_base.php');
    $prefecture=(int)$_GET['prefecture'];
    
    $listePersonnel=getPersonnel($prefecture, $_GET['categorie']); 
    $statistiques=getStatistique($prefecture);
    
    $displayStatistique='';
    
    foreach ($statistiques as $statistique)
    {
    $displayStatistique.='<div class="col-lg-3 col-xs-12 col-sm-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 class="panel-title">'.$statistique['categorie'].'</h1>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Femme: <span class="badge succes">'.$statistique['fille'].'</span></li>
                        <li class="list-group-item">Homme: <span class="badge succes">'.($statistique['nombre']-$statistique['fille']).'</span></li>
                        <li class="list-group-item">Total: <span class="badge succes">'.$statistique['nombre'].'</span></li>
                    </ul>
                </div>
            </div>
        </div>';
    }
      
    
    $displayPersonnel='<table class="table table-bordered table-condensed col-lg-12 col-sm-12 col-xs-12">
                            <tr>
                                <th>Matricule</th>
                                <th>CIN</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Sexe</th>
                                <th>Date Nais</th>
                                <th>Lieu Nais</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Catégorie</th>
                                <th>Responsabilité</th>
                            <tr>';

    foreach ($listePersonnel as $personnel)
    {
    $displayPersonnel.='<tr>
        <td>'.$personnel['matricule'].'</td>
        <td>'.$personnel['cin'].'</td>
        <td>'.$personnel['nom'].'</td>
        <td>'.$personnel['prenom'].'</td>
        <td>'.$personnel['sexe'].'</td>
        <td>'.$personnel['date'].'</td>
        <td>'.$personnel['lieu_naissance'].'</td>
        <td>'.$personnel['adresse'].'</td>
        <td>'.$personnel['telephone'].'</td>
        <td>'.$personnel['email'].'</td>
        <td>'.$personnel['personne_contact'].'</td>
        <td>'.$personnel['categorie'].'</td>
        <td>'.$personnel['titre_responsabilite'].'</td>
    </tr>'; 
    }
    
    $displayPersonnel.='</table>';
    
    $reponse=['personnel'=>$displayPersonnel, 'statistique'=>$displayStatistique];
    echo json_encode($reponse);
}