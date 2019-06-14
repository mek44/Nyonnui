<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste des bons</title>
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
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <h1>Liste des bons</h1>
                            <div class="table-responsive" id="bons">
                                <table class="table table-bordered table-striped table-condensed">
                                    <tr class="entete-table">
                                        <th>Date</th>
                                        <th>Matricule</th>
                                        <th>Prénoms</th>
                                        <th>Nom</th>
                                        <th>Tel</th>
                                        <th>Montant</th>
                                        <th>Payer</th>
                                        <th>Reste</th>
                                        <th></th>
                                    </tr>

                                    <?php
                                    foreach($bons as $bon)
                                    {?>
                                        <tr>
                                            <td><?php echo $bon['date'];?></td>
                                            <td><?php echo $bon['matricule'];?></td>
                                            <td><?php echo $bon['prenom'];?></td>
                                            <td><?php echo $bon['nom'];?></td>
                                            <td><?php echo $bon['telephone'];?></td>
                                            <td class="montant"><?php echo formatageMontant($bon['montant']);?></td>
                                            <td class="montant"><?php echo formatageMontant($bon['payer']);?></td>
                                            <td class="montant"><?php echo formatageMontant($bon['montant']-$bon['payer']);?></td>
                                            <td><a href="payer_bon.php?id=<?php echo $bon['id_bon'];?>">payer</a></td>
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
		<script src="js/liste_bon.js"></script>
	</body>
</html>