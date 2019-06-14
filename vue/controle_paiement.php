<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Contôle de paiement</title>
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
                                <label class="control-label">Classe</label>
                                <select id="classe" class="form-control">
                                    <?php
                                    foreach ($listeClasse as $classe)
                                    {?>
                                    <option value="<?php echo $classe['id'];?>"><?php echo formatClasse($classe);?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="row saut">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <h1>Contôle de paiement</h1>
                            <div class="table-responsive" id="controle">
                                <table class="table table-bordered table-striped table-condensed">
                                        <tr class="entete-table">
                                            <th>Matricule</th>
                                            <th>Prénoms</th>
                                            <th>Nom</th>
                                            <th>Sept</th>
                                            <th>Oct</th>
                                            <th>Nov</th>
                                            <th>Déc</th>
                                            <th>Jan</th>
                                            <th>Fév</th>
                                            <th>Mar</th>
                                            <th>Avr</th>
                                            <th>Mai</th>
                                        </tr>
                                        
                                        <?php
                                        foreach($controles as $controle)
                                        {?>
                                            <tr>
                                                <td><?php echo $controle['matricule'];?></td>
                                                <td><?php echo $controle['prenom'];?></td>
                                                <td><?php echo $controle['nom'];?></td>
                                                <?php
                                                foreach ($listeMois as $mois)
                                                {?>
                                                <td class="montant"><?php echo formatageMontant($controle['mois'.$mois]);?></td>
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
		<script src="js/controle_paiement.js"></script>
	</body>
</html>