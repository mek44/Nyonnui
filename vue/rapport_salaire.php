<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Rapport de salaire</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<h1 class="col-lg-12" style="text-align: center;">Rapport de salaire</h1>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" enctype="multipart/form-data" class="form-inline col-lg-12">
					<div class="form-group">
						<label class="control-label col-lg-5">Mois</label>
						<div class="col-lg-7">
							<select class="form-control" id="mois">
								<?php 
								foreach ($listeMois as $option=>$valeur) 
								{
									if($mois==$valeur)
									{?>
										<option value="<?php echo $valeur; ?>" selected><?php echo $option; ?></option> 
									<?php
									}
									else
									{?>
										<option value="<?php echo $valeur; ?>"><?php echo $option; ?></option> 
									<?php
									}										
								}
								?>
							</select>
						</div>
					</div>
				</form>
			</div>
				
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Rapport</h1>
						</div>
						
						<div class="table-responsive" id="salaire">
							<table class="table table-striped table-condensed table-bordered">
								<tr>
									<th>Date</th>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Volume horaire</th>
									<th>Taux horaire</th>
									<th>Salaire de base</th>
									<th>Somme</th>
								</tr>

								<?php
								foreach ($rapport as $salaire) 
								{?>
									<tr>
										<td><?php echo $salaire['date_paie']; ?></td>
										<td><?php echo $salaire['matricule']; ?></td>
										<td><?php echo $salaire['nom']; ?></td>
										<td><?php echo $salaire['prenom']; ?></td>
										<td><?php echo $salaire['volume_horaire']; ?></td>
										<td><?php echo formatageMontant($salaire['taux_horaire']); ?></td>
										<td><?php echo formatageMontant($salaire['salaire_base']); ?></td>
										<td><?php echo formatageMontant(($salaire['volume_horaire']*$salaire['taux_horaire'])+$salaire['salaire_base']); ?></td>
									</tr>
								<?php
	
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4">
					<p class="total-salaire">Total: <span id="total"><?php echo formatageMontant($total); ?></span></p>
				</div>
			</div>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/rapport_salaire.js"></script>
	</body>
</html>