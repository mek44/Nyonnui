<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouvelle dépense</title>
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
			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-6 col-lg-offset-3 col-sm-5 col-sm-offset-3 col-xs-12">
					<h3 class="col-lg-12" style="text-align: center;">Ajouter une dépense</h3>
					<form method="post" class="well form-horizontal col-lg-12 col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<label for="date" class="col-lg-3 col-xs-2 col-sm-3 control-label">Date:</label>
							<div class="col-lg-8 col-xs-10 col-sm-9">
								<div class="row">
									<div class="col-lg-3 col-xs-4 col-sm-4"><input type="text" name="jour" id="jour" class="form-control" placeholder="JJ" value="<?php echo $jour;?>" /></div>
									<div class="col-lg-3 col-xs-4 col-sm-4"><input type="text" name="mois" id="mois" class="form-control" placeholder="MM" value="<?php echo $mois;?>" /></div>
									<div class="col-lg-3 col-xs-4 col-sm-4"><input type="text" name="annee" id="annee" class="form-control" placeholder="AAAA" value="<?php echo $annee;?>" /></div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="categorie" class="col-lg-3 col-xs-5 col-sm-3 control-label">Catégorie:</label>
							<div class="col-lg-8 col-xs-7 col-sm-9">
								<select id="categorie" name="categorie" class="form-control">
									<?php
									foreach($listeCategorie as $categorie)
									{?>	
									<option value="<?php echo $categorie['id'];?>"><?php echo $categorie['libelle'];?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group has-feedback">
							<label for="montant" class="col-lg-3 col-xs-5 col-sm-3 control-label">Montant:</label>
							<div class="col-lg-8 col-xs-7 col-sm-9">
								<input type="text" name="montant" id="montant" class="form-control" />
							</div>
						</div>
						
						<div class="form-group has-feedback">
							<label for="beneficiaire" class="col-lg-3 col-xs-5 col-sm-3 control-label">Bénéficiaire:</label>
							<div class="col-lg-8 col-xs-7 col-sm-9">
								<input type="text" name="beneficiaire" id="beneficiaire" class="form-control" />
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-8 col-lg-offset-4">
								<input type="submit" class="btn btn-success" name="ajouter" value="Valider" id="envoyer" />
								<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
							</div>
						</div>
					</form>
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
	</body>
</html>