<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouvel utilisateur</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<?php
		if($pageValide)
		{?>
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12" style="text-align: center;">Nouvel utilisateur</h1>
				<form method="post" class="well form-horizontal col-lg-8 col-lg-offset-2 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-inscription">
					<div class="form-group has-feedback">
						<label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="text" class="form-control texte" id="nom" name="nom" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 2 caractères</span>
					</div>
					
					<div class="form-group has-feedback">
						<label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Adresse:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="text" class="form-control texte" id="adresse" name="adresse" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 5 caractères</span>
					</div>
					
					<div class="form-group has-feedback">
						<label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Téléphone:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="text" class="form-control texte" id="telephone" name="telephone" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le numéro de téléphone est incorrect</span>
					</div>
					
					<div class="form-group has-feedback">
						<label for="login" class="col-lg-3 col-xs-5 col-sm-4 control-label">Login:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="text" class="form-control texte" id="login" name="login" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le login doit contenir au moins 5 caractères</span>
					</div>
					
					<div class="form-group has-feedback">
						<label for="fonction" class="col-lg-3 col-xs-5 col-sm-4 control-label">Fonction:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<select class="form-control texte" id="fonction" name="fonction">
								<?php
								foreach($listeFonction as $fonction)
								{?>
								<option value="<?php echo $fonction['id'];?>"><?php echo $fonction['nom'];?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group has-feedback">
						<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Département:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<select class="form-control texte" id="region" name="region">
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
					
					<div class="form-group has-feedback">
						<label for="prefecture" class="col-lg-3 col-xs-5 col-sm-4 control-label">Commune:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<select class="form-control texte" id="prefecture" name="prefecture">
							<?php 
							foreach($listePrefecture as $prefecture)
							{?>
								<option value="<?php echo $prefecture['id'];?>"><?php echo $prefecture['nom'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					<div class="form-group" id="divEcole">
						<label for="ecole" class="col-lg-3 col-xs-5 col-sm-4 control-label">Ecole:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<select class="form-control texte" id="ecole" name="ecole">
							<?php 
							foreach($listeEcole as $ecole)
							{?>
								<option value="<?php echo $ecole['id'];?>"><?php echo $ecole['nom'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					<div class="form-group has-feedback">
						<label for="passe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Mot de passe:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="password" class="form-control texte" id="passe" name="passe" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le mot de passe doit contenir au moins 5 caractères</span>
					</div>
					
					<div class="form-group has-feedback">
						<label for="confirmation" class="col-lg-3 col-xs-5 col-sm-4 control-label">Confirmer:</label>
						<div class="col-lg-9 col-xs-7 col-sm-8">
							<input type="password" class="form-control texte" id="confirmation" name="confirmation" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Ce mot de passe doit être identique au premier</span>
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
									<h1 class="modal-title" id="titre-alert"><?php echo $observation; ?> Nouvel utilisateur</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['nouveau_user']))
										{
											echo $_COOKIE['nouveau_user']; 
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
		<?php
		}
		else
		{?>
			<p>Vous n'avez pas accès à cette page</p>
		<?php
		}
		
			include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/ajouter_utilisateur.js"></script>
	</body>
</html>