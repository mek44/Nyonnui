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
                    <h1 class="col-lg-12" style="text-align: center;">Rapport de comptabilité</h1>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-4">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title">Mensualité par classe</h1>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>   
                                            <th>Classe</th>
                                            <th>Montant</th>
                                            <th>Reduction</th>
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
                            
                            
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title">Dépenses par catégorie</h1>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>   
                                            <th>Catégorie</th>
                                            <th>Montant</th>
                                        </tr>

                                        <?php
                                        foreach ($depenses as $depense)
                                        {
                                        ?>
                                            <tr>
                                                <td><?php echo $depense['libelle']; ?></td>
                                                <td><?php echo formatageMontant($depense['montant']); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-8 col-sm-8 col-xs-8">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title">Salaire</h1>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>   
                                            <th>Matricule</th>
                                            <th>Prénom et Nom</th>
                                            <th>S. Base</th>
                                            <th>Volume Horaire</th>
                                            <th>Taux Horaire</th>
                                            <th>Prestation</th>
                                            <th>Total</th>
                                        </tr>

                                        <?php
                                        foreach ($salaires as $salaire)
                                        {
                                        ?>
                                            <tr>
                                                <td><?php echo $salaire['matricule']; ?></td>
                                                <td><?php echo $salaire['prenom'].' '.$salaire['nom']; ?></td>
                                                <td><?php echo formatageMontant($salaire['sal_base']); ?></td>
                                                <td><?php echo $salaire['volume']; ?></td>
                                                <td><?php echo formatageMontant($salaire['taux']); ?></td>
                                                <td><?php echo formatageMontant($salaire['prestation']); ?></td>
                                                <td><?php echo formatageMontant($salaire['sal_base']+$salaire['prestation']); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title">Bons</h1>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>   
                                            <th>Matricule</th>
                                            <th>Prénom et Nom</th>
                                            <th>Montant</th>
                                        </tr>

                                        <?php
                                        foreach ($bons as $bon)
                                        {
                                        ?>
                                            <tr>
                                                <td><?php echo $bon['matricule']; ?></td>
                                                <td><?php echo $bon['prenom'].' '.$bon['nom']; ?></td>
                                                <td><?php echo formatageMontant($bon['montant']); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                else
                {?>
                        <p>Vous n'avez pas à cette page</p>
                <?php
                }
                ?>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>