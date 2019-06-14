<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste des dépenses</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<form class="form-inline col-lg-12 col-sm-12 col-md-12 col-xs-12">	
					<div class="form-group">
						<label class="control-label">Du </label>
						<input type="text" name="jourDebut" id="jourDebut" class="form-control" placeholder="JJ" value="1" size="2" />
						<input type="text" name="moisDebut" id="moisDebut" class="form-control" placeholder="MM" value="<?php echo $mois;?>" size="2" />
						<input type="text" name="anneeDebut" id="anneeDebut" class="form-control" placeholder="AAAA" value="<?php echo $annee;?>" size="3" />
					</div>
					
					<div class="form-group">
						<label class="control-label"> au </label>
						<input type="text" name="jourFin" id="jourFin" class="form-control" placeholder="JJ" value="<?php echo $jour;?>" size="2" />
						<input type="text" name="moisFin" id="moisFin" class="form-control" placeholder="MM" value="<?php echo $mois;?>" size="2" />
						<input type="text" name="anneeFin" id="anneeFin" class="form-control" placeholder="AAAA" value="<?php echo $annee;?>" size="3" />
					</div>
					
					<div class="form-group">
						<label class="control-label">Catégorie:</label>
						<select name="categorie" id="categorie" class="form-control">
							<option value="0">Toutes</option>
							<?php
							foreach($listeCategorie as $categorie)
							{?>
								<option value="<?php echo $categorie['id'];?>"><?php echo $categorie['libelle'];?></option>
							<?php
							}
							?>
						</select>
					</div>
					
					<button class="btn btn-success" id="rechercher"><span class="glyphicon glyphicon-search"></span> Rechercher</button>
						
				</form>
			</div>

			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
					<h3>Listes des dépenses</h3>
					<div class="table-responsive" id="listeDepense">
						<table class="table table-bordered table-striped table-condensed">
							<tr class="entete-table">
								<th>Date</th>
								<th>Catégorie</th>
								<th>Montant</th>
								<th>Bénéficiaire</th>
							</tr>
							
							<?php
							foreach($listeDepense as $depense)
							{?>
								<tr>
									<td><?php echo $depense['date_depense'];?></td>
									<td><?php echo $depense['libelle'];?></td>
									<td><?php echo $depense['montant'];?></td>
									<td><?php echo $depense['beneficiaire'];?></td>
								</tr>
							<?php
							}
							?>
						</table>
					</div>	
					
				</div>
			</div>
			
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/liste_depense.js"></script>
	</body>
</html>