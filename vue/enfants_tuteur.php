<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Liste des enfants</title>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link rel="icon" href="fonts/glyphicons-halflings-regular.woff" />
        <link href="css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
                <?php 
                    include_once('controle/entete.php');
                    include_once 'modele/fonctionsEDT.php';
                    include_once 'modele/afficheAbsences.php';
                ?>
        </header>

        <div class="container">
            <?php
            if($pageValide)
            {?>
            <div class="row">
                <div class="col-lg-9 col-xs-12 col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h1 class="panel-title">Liste des enfants inscrits</h1>
                        </div>

                        <div class="table-responsive" id="tableEleve">
                            <table class="table table-bordered table-striped table-condensed">
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Classe</th>
                                    <th colspan="4">Consulter ...</th>
                                </tr>

                                <?php
                                $i=0;
                                foreach($listeEnfants as $enfants)
                                {?>
                                        <tr>
                                                <td><?php echo $enfants['matricule'];?></td>
                                                <td><?php echo $enfants['nom'];?></td>
                                                <td><?php echo $enfants['prenom'];?></td>
                                                <td><?php echo formatClasse($enfants); ?></td>
                                                <td><a href="bulletin.php?id=<?php echo $enfants['id'];?>">bulletin</a></td>
                                                <td><a href="mensualite_tuteur.php?id=<?php echo $enfants['id'];?>">Mensualité</a></td>
                                                <td><a href="?EDT&idClasse=<?php echo $enfants['idClasse'];?>&enfant=<?php  echo $i; ?>">Emploi du temps</a></td>
                                                <td><a href="?absences&idClasse=<?php echo $enfants['idClasse'];?>&enfant=<?php  echo $i; ?>">absences</a></td>
                                        </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive" id="services">
                    <p>&nbsp;</p>
                    <?php 
                        if (isset($_GET['idClasse'])){
                           $i = $_GET['enfant'];
                           $enfants = $listeEnfants[$i];
                            if(isset($_GET['absences'])){
                                echo '<div class="panel panel-success">';
                                echo '<div class="panel-heading">';
                                echo "<h1 class='panel-title'>Absences de ".$enfants['prenom'].' '.$enfants['nom']."</h1>";
                                echo "</div>";
                                echo afficheAbsences($enfants['idClasse'], $enfants['id'], $_SESSION['annee']);
                                echo "</div>";
                            }elseif (isset($_GET['EDT'])){
                                echo '<div class="panel panel-success">';
                                echo '<div class="panel-heading">';
                                echo "<h1 class='panel-title'>Emploi du temps de ".$enfants['prenom'].' '.$enfants['nom']."</h1>";
                                echo "</div>";
                                echo afficheEmploie($enfants['idClasse']);
                                echo "</div>";
                            }
                        }
                    ?>
                </div>
            </div>
        <?php
        }
        else
        {?>
            <p>Vous n'avez pas accès à cette page</p>
        <?php
        }
        ?>
        </div>

            <script src="js/jquery.js"></script>
            <script src="js/bootstrap.js"></script>
            <script src="js/resultats.js"></script>
    </body>
</html>