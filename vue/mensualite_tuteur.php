<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8" />
            <title>Mensualité élève</title>
            <link href="css/bootstrap.css" rel="stylesheet" />
            <link href="css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
                <?php include_once('controle/entete.php'); ?>
        </header>

        <div class="container">	
        <?php
        if($pageValide)
        {?>
            <div class="row">
                <form class="form-horizontal col-lg-6 col-lg-12 col-sm-6 well">
                    <fieldset>
                        <legend>Informations élève</legend>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label for="matricule" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matricule:</label>
                                    <div class="col-lg-5 col-xs-7 col-sm-8">
                                        <input type="text" class="form-control texte" id="matricule" name="matricule" value="<?php echo $infos['matricule'];?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
                                    <div class="col-lg-8 col-xs-7 col-sm-8">
                                        <input type="text" class="form-control texte" id="nom" name="nom" value="<?php echo $infos['nom'];?>"disabled />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prenom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Prénom:</label>
                                    <div class="col-lg-8 col-xs-7 col-sm-8">
                                        <input type="text" class="form-control texte" id="prenom" name="prenom" value="<?php echo $infos['prenom'];?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sexe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Sexe:</label>
                                    <div class="col-lg-3 col-xs-7 col-sm-8">
                                        <input type="text" id="sexe" name="sexe" class="form-control" value="<?php echo $infos['sexe'];?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 col-xs-5 col-sm-4 control-label">Niveau:</label>
                                    <div class="col-lg-4 col-xs-3 col-sm-3">
                                        <input type="text" class="form-control" id="niveau" value="<?php echo formatClasse($infos);?>" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                    <img src="imageseleves/<?php echo $infos['photo'];?>" alt="image" class="img-responsive" id="image" />
                            </div>
                        </div>
                    </fieldset>
                </form>

                <div class="col-lg-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h1 class="panel-title">Versement(s) effectué(s)</h1>
                        </div>

                        <div class="table-responsive" id="versement">
                            <table class="table table-striped table-condensed table-bordered">
                                <tr>
                                        <th>Date</th>
                                        <th>Mois</th>
                                        <th>Payé</th>
                                        <th>Réduction</th>
                                        <th>Reçu</th>
                                </tr>
                                <?php
                                foreach ($listeVersement as $versement)
                                {?>
                                    <tr>
                                        <td><?php echo $versement['date_paie'];?></td>
                                        <td><?php echo $listeMois[$versement['mois']-1]; ?></td>
                                        <td><?php echo formatageMontant($versement['montant']-$versement['reduction']); ?></td>
                                        <td><?php echo formatageMontant($versement['reduction']);?></td>
                                        <td><?php echo$versement['num_recus'];?></td>
                                    </tr>	
                                <?php
                                    $total+=$versement['montant']-$versement['reduction'];
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <p class="total-versement">Total versement: <span id="total"><?php echo formatageMontant($total);?></span></p>
                    </div>
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

        <?php include_once('pied_page.php'); ?>

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
    </body>
</html>