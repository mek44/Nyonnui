<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Etat journalier de paiement</title>
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
                    <div class="row saut">
                        <form class="form-inline col-lg-12 col-sm-12 col-md-12 col-xs-12">	
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <input type="text" name="jour" id="jour" class="form-control-perso" placeholder="JJ" value="<?php echo $jour;?>" size="2" />
                                <input type="text" name="mois" id="mois" class="form-control-perso" placeholder="MM" value="<?php echo $mois;?>" size="2" />
                                <input type="text" name="annee" id="annee" class="form-control-perso" placeholder="AAAA" value="<?php echo $annee;?>" size="3" />
                            </div>

                            <button class="btn btn-success" id="rechercher"><span class="glyphicon glyphicon-search"></span> Rechercher</button>

                        </form>
                    </div>

                    <div class="row saut">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <h1>Etat journalier de paiement</h1>
                            <div class="table-responsive" id="etats">
                                <table class="table table-bordered table-striped table-condensed">
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
                                        </tr>

                                        <?php
                                        foreach($etats as $etat)
                                        {?>
                                            <tr>
                                                <td><?php echo $etat['matricule'];?></td>
                                                <td><?php echo $etat['prenom'].' '.$etat['nom'];?></td>
                                                <td><?php echo formatClasse($etat);?></td>
                                                <td><?php echo formatageMontant($etat['montant']);?></td>
                                                <?php
                                                foreach ($listeMois as $mois)
                                                {?>
                                                <td><?php echo ($etat['mois'.$mois]?'x':'');?></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                </table>
                            </div>	
                        </div>
                    </div>
                    
                    <p><a href="imprimer_etat.php">Imprimer</a></p>
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
		<script src="js/etat_journalier_paiement.js"></script>
	</body>
</html>