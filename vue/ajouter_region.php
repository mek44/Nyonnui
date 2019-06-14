<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouveau département</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12" style="text-align: center;">Nouveau département</h1>
				<form method="post" class="well form-horizontal col-lg-6 col-lg-offset-3 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-region">
					<div class="form-group has-feedback">
						<label for="nom" class="col-lg-1 col-xs-5 col-sm-4 control-label">Nom:</label>
						<div class="col-lg-11 col-xs-7 col-sm-8">
							<input type="text" class="form-control texte" id="nom" name="nom" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 3 caractères</span>
					</div>
					
					<div class="form-group">
						<div class="col-lg-4 col-lg-offset-4">
							<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
							<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
						</div>
					</div>
					
					<div class="modal fade" id="alert" data-backdrop="false">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">x</button>
									<h1 class="modal-title" id="titre-alert"><?php echo $observation; ?> Nouveau département</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['nouvelle_region']))
										{
											echo $_COOKIE['nouvelle_region']; 
										}
										else
										{
											echo 'Les données ne sont pas valides';
										}
									?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/ajouter_region.js"></script>
	</body>
</html>