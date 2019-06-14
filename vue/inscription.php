<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Inscription</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12" style="text-align: center;">Inscription d'un élève</h1>
				<form method="post" enctype="multipart/form-data" class="well form-horizontal col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-inscription">
					<div class="row">
						<div class="col-lg-6">
							<fieldset>
								<legend>Informations élève</legend>
								<div class="form-group has-feedback">
									<label for="matricule" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matricule:</label>
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="matricule" name="matricule" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerMatricule"></span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="passe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Mot de passe:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="password" class="form-control texte" id="passe" name="passe" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPasse"></span>
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
									<label for="photo" class="col-lg-3 col-xs-5 col-sm-4 control-label">Photo:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="file" name="photo" class="form-control" id="photo" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
								</div>	
							</fieldset>
							
							<fieldset>
								<legend>Filiation</legend>
								<div class="form-group has-feedback">
									<label for="pere" class="col-lg-3 col-xs-5 col-sm-4 control-label">Père</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="pere" name="pere" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPere">Le nom du père est vide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="mere" class="col-lg-3 col-xs-5 col-sm-4 control-label">Mère:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="mere" name="mere" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerMere">Le nom de la mère est vide</span>
								</div>
							</fieldset>
							
							<fieldset>
								<legend>Tuteur</legend>
								
								<div class="form-group has-feedback">
									<input type="checkbox" class="col-lg-3 col-xs-3 col-sm-3 control-label" id="choixTuteur" name="choixTuteur" />
									<label for="choixTuteur" class="col-lg-9 col-xs-9 col-sm-9">Nouveau tuteur</label>
								</div>
								
								<div class="form-group">
									<label for="Rechercher" class="col-lg-3 col-xs-5 col-sm-4 control-label">Rechercher:</label>
									<div class="input-group col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="recherche" id="recherche" class="form-control" placeholder="Numéro de téléphone" />
										<span class="input-group-btn"><button id="validationRecherche" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button></span>
									</div>
								</div>
								
								<div class="form-group has-feedback">
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="hidden" class="form-control" id="tuteur" name="tuteur" />
									</div>
								</div>
				
								<div class="form-group has-feedback">
									<label for="nomTuteur" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte tuteur" id="nomTuteur" name="nomTuteur" disabled />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNomTuteur">Le nom est vide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="adresse" class="col-lg-3 col-xs-5 col-sm-4 control-label">Adresse:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte tuteur" id="adresse" name="adresse" disabled />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerAdresse">L'adresse est vide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Téléphone:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control tuteur" id="telephone" name="telephone" disabled />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerTelephone">Le numéro de téléphone est invalide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="passeTuteur" class="col-lg-3 col-xs-5 col-sm-4 control-label">Mot de passe:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="password" class="form-control texte tuteur" id="passeTuteur" name="passeTuteur" disabled />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPasseTuteur">Le mot de passe ne doit pas être vide</span>
								</div>
							</fieldset>
						</div>
						
						
						<div class="col-lg-6">
							<fieldset>
								<legend>Cours</legend>
								<div class="form-group">
									<label class="col-lg-5 col-xs-5 col-sm-4 control-label">Date d'inscription:</label>
									<div class="col-lg-2 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="jourInscription" name="jourInscription" placeholder="JJ" value="<?php echo $jour;?>" />
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
									<label for="cours" class="col-lg-5 col-xs-5 col-sm-4 control-label">Cours demandé:</label>
									<div class="col-lg-4 col-xs-7 col-sm-8">
										<select class="form-control" id="cours" name="cours">
											<?php
											foreach($listeClasse as $classe)
											{?>
												<option value="<?php echo $classe['id']; ?>"><?php echo $classe['niveau'].' '.$classe['option_lycee'].' '.$classe['intitule']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerMatricule"></span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="ecoleOrigine" class="col-lg-5 col-xs-5 col-sm-4 control-label">Ecole d'origine:</label>
									<div class="col-lg-6 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="ecoleOrigine" name="ecoleOrigine" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
								</div>
								
								<div class="form-group has-feedback">
									<label for="pv" class="col-lg-5 col-xs-5 col-sm-4 control-label">PV dernier examen:</label>
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" class="form-control" id="pv" name="pv" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPv">Le PV n'est pas valide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="rang" class="col-lg-5 col-xs-5 col-sm-4 control-label">Rang dernier examen:</label>
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" name="rang" class="form-control" id="rang" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerRang">Le rang n'est pas valide</span>
								</div>	
								
								<div class="form-group has-feedback">
									<label for="session" class="col-lg-5 col-xs-5 col-sm-4 control-label">Session dernier examen:</label>
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" name="session" class="form-control" id="session" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangersession">La session n'est pas valide</span>
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
									<h1 class="modal-title">Inscription</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['inscription_eleve']))
										{
											echo $_COOKIE['inscription_eleve']; 
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
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/inscription.js"></script>
	</body>
</html>