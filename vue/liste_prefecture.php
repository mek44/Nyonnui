<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste des préfectures</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<?php
		if(isset($_SESSION['user']) && ($_SESSION['user']['fonction']!='superadministrateur' || $_SESSION['user']['fonction']!='administrateur'))
		{?>	
		<div class="container">
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" class="form-inline col-lg-12">
					<div class="form-group has-feedback">
						<label for="region" class="col-lg-3 control-label">  Département:   </label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select class="form-control texte" id="region" name="region">
							<option value="0">Toutes</option>
							<?php 
							foreach($listeRegion as $region)
							{?>
								<option value="<?php echo $region['id'];?>"><?php echo $region['nom'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
				</form>
			</div>

			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-5 col-sm-12 col-xs-12">
					<h1 style="text-align: center;">Liste des communes (CS)</h1>
					<div class="panel panel-success">
						<div class="table-responsive" id="listePrefecture">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Nom</th>
									<th>Départements</th>
								</tr>
								
								<?php
								foreach($listePrefecture as $prefecture)
								{
								?>
									<tr class="prefecture" id="<?php echo $prefecture['id'];?>">
										<td style="width: 30%"><?php echo $prefecture['nom'];?></td>
										<td><?php echo $prefecture['nom_region'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 col-lg-offset-1 col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0">
					<h1 style="text-align: center;">Edition Département</h1>
					<form method="post" action="modele/liste_prefecture.php" class="well form-horizontal" id="form-prefecture">
						<div class="form-group has-feedback">
							<div class="col-lg-10 col-xs-7 col-sm-8">
								<input type="hidden" class="form-control" id="id_prefecture" name="id_prefecture" />
							</div>
						</div>
						
						<div class="form-group has-feedback">
							<label for="region" class="col-lg-2 col-xs-5 col-sm-4 control-label">Département:</label>
							<div class="col-lg-10 col-xs-7 col-sm-8">
								<select name="region" id="id_region" class="form-control">
									<?php
									foreach($listeRegion as $region)
									{?>
										<option value="<?php echo $region['id']; ?>"><?php echo $region['nom']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group has-feedback">
							<label for="nom" class="col-lg-2 col-xs-5 col-sm-4 control-label">Nom:</label>
							<div class="col-lg-10 col-xs-7 col-sm-8">
								<input type="text" class="form-control texte" id="nom" name="nom" />
								<span class="glyphicon form-control-feedback"></span>
							</div>
							<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 3 caractères</span>
						</div>
						
						<div class="form-group">
							<div class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
								<input type="submit" class="btn btn-success" value="Valider" id="valider" />
								<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		}
		else
		{?>
			<p>vous n'avez pas accès à cette page</p>
		<?php
		}
		?>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/liste_prefecture.js"></script>
	</body>
</html>