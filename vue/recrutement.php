<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Récrutement</title>
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
				<h1 class="col-lg-12" style="text-align: center;">Récrutement</h1>
				<form method="post" enctype="multipart/form-data" class="well form-horizontal col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-inscription">
					<div class="row">
						<div class="col-lg-6">
							<fieldset>
								<legend>Informations du personnel</legend>
									<div class="form-group has-feedback">
									<label for="matricule" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matricule:</label>
									<div class="col-lg-5 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="matricule" name="matricule" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerMatricule"></span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="nom" name="nom" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom est vide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="prenom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Prénom:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="prenom" name="prenom" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPrenom">Le prénom est vide </span>
								</div>
								
								<div class="form-group">
									<label for="sexe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Sexe:</label>
									<div class="col-lg-5 col-xs-7 col-sm-8">
										<select id="sexe" name="sexe" class="form-control">
											<option value="M">Masculin</option>
											<option value="F">Feminin</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-lg-3 col-xs-5 col-sm-4 control-label">Date de naissance:</label>
									<div class="col-lg-2 col-xs-3 col-sm-3">
										<input type="text" class="form-control" id="jourNaissance" name="jourNaissance" placeholder="JJ" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<div class="col-lg-2 col-xs-3 col-sm-3">
										<input type="text" class="form-control" id="moisNaissance" name="moisNaissance"  placeholder="MM"/>
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<div class="col-lg-3 col-xs-3 col-sm-3">
										<input type="text" class="form-control" id="anneeNaissance" name="anneeNaissance" placeholder="AAAA" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerDateNais">La date de naissance n'est pas valide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="lieuNaissance" class="col-lg-3 col-xs-5 col-sm-4 control-label">Lieu de naissance:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="lieuNaissance" class="form-control texte" id="lieuNaissance" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerLieuNais">Le lieu de naissance est vide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="adrsse" class="col-lg-3 col-xs-5 col-sm-4 control-label">Adresse:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="adresse" class="form-control texte" id="adresse" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerLieuNais">L'adresse est vide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Téléphone:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="telephone" class="form-control" id="telephone" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerTelephone">Le numéro de téléphone est invalide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="passe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Mot de passe:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="passe" class="form-control" id="passe" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPasse">Le mot de passe ne doit pas être vide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="code" class="col-lg-3 col-xs-5 col-sm-4 control-label">Code:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="code" class="form-control" id="code" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerCode">Le code ne doit pas être vide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="photo" class="col-lg-3 col-xs-5 col-sm-4 control-label">Photo:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="file" name="photo" class="form-control" id="photo" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
								</div>	
							</fieldset>
						</div>
						
						
						<div class="col-lg-6">
							<fieldset>
								<legend>Affectation</legend>
								<div class="form-group">
									<label class="col-lg-5 col-xs-5 col-sm-4 control-label">Date d'engagement:</label>
									<div class="col-lg-2 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="jourInscription" name="jourInscription" placeholder="JJ"  value="<?php echo $jour;?>" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<div class="col-lg-2 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="moisInscription" name="moisInscription" placeholder="MM" value="<?php echo $mois;?>" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="anneeInscription" name="anneeInscription" placeholder="AAAA" value="<?php echo $annee;?>" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerDateIns">La date d'inscription n'est pas valide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="fonction" class="col-lg-5 col-xs-5 col-sm-4 control-label">Fonction:</label>
									<div class="col-lg-7 col-xs-7 col-sm-8">
										<input type="text" name="fonction" class="form-control texte" id="fonction" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerRang">Vous devez indiquer la fonction du personnel</span>
								</div>	
				
								
								<div class="form-group has-feedback">
									<label for="salaire" class="col-lg-5 col-xs-5 col-sm-4 control-label">Salaire de base:</label>
									<div class="col-lg-6 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="salaire" name="salaire" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerSalaire">Le salaire n'est pas valide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="taux" class="col-lg-5 col-xs-5 col-sm-4 control-label">Taux horaire:</label>
									<div class="col-lg-6 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="taux" name="taux" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPv">Le taux horaire n'est pas valide</span>
								</div>
							</fieldset>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-3 col-lg-offset-5">
							<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
							<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
						</div>
					</div>
					
					
					<div class="modal fade" id="alert" data-backdrop="false">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">x</button>
									<h1 class="modal-title" id="titre-alert"><?php echo $observation; ?> Récrutement</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['recrutement']))
										{
											echo $_COOKIE['recrutement']; 
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
		<script src="js/recrutement.js"></script>
	</body>
</html>