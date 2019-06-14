<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Rapport de comptabilité</title>
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
                    <h1 class="col-lg-12" style="text-align: center;">Frais de scolarité et annexe</h1>
                    <h2 class="col-lg-12" style="text-align: center;">pour l'année <?php echo $annee ?></h2>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-4">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title">Mensualité par classe</h1>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>
                                            <?php
                                                foreach ($niveaux as $niveau){
                                            ?>
                                            <th><?php echo niveau['Libelle'] ?></th>
                                            <?php
                                                }
                                            ?>
                                        </tr>

                                        <?php
                                        foreach ($mensualites as $mensualite)
                                        {
                                        ?>
                                            <tr>
                                                <td><?php echo formatClasse($mensualite); ?></td>
                                                <td><?php echo formatageMontant($mensualite['montant']-$mensualite['reduction']); ?></td>
                                                <td><?php echo formatageMontant($mensualite['reduction']); ?></td>
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
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>