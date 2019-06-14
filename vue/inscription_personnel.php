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
				<h1 class="col-lg-12" style="text-align: center;">Inscription personnel</h1>
				<form method="post" class="well form-horizontal col-lg-12 col-xs-12 col-sm-12">
					<div class="row">
						<div class="col-lg-6">
							<fieldset>
								<div class="form-group has-feedback">
									<label for="matricule" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matricule:</label>
									<div class="col-lg-3 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="matricule" name="matricule" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerMatricule">Le numéro de matricule est vide</span>
								</div>														    
								
								<div class="form-group has-feedback">
									<label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="nom" name="nom" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom est vide</span>
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
									<label for="sexe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Sexe:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
                                                                            <select name="sexe" class="form-control" id="sexe">
                                                                                <option value="M">Homme</option>
                                                                                <option value="F">Femme</option>
                                                                            <select>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerLieuNais">L'adresse est vide</span>
								</div>
								
								<div class="form-group has-feedback">
									<label for="adresse" class="col-lg-3 col-xs-5 col-sm-4 control-label">Adresse:</label>
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
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le numéro n'est pas valide</span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label for="personne_contact" class="col-lg-3 col-xs-5 col-sm-4 control-label">Personne à contacter:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="personne_contact" class="form-control texte" id="personne_contact" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le nom de la personne à contacter est vide</span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label for="categorie" class="col-lg-3 col-xs-5 col-sm-4 control-label">Catégorie:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
                                                                            <select name="categorie" class="form-control" id="categorie">
                                                                                <option>Personnel Administration</option>
                                                                                <option>Enseignant Primaire</option>
                                                                                <option>Enseignant Secondaire</option>
                                                                            </select> 
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;"></span>
								</div>	
							</fieldset>
                                                </div>
							
						
						
						<div class="col-lg-6">
							<fieldset>
								<div class="form-group has-feedback">
									<label for="cin" class="col-lg-3 col-xs-5 col-sm-4 control-label">Numéro CIN:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="cin" name="cin" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le numéro de la carte est vide</span>
								</div>
                                                            
								<div class="form-group has-feedback">
									<label for="prenom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Prénom:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" class="form-control texte" id="prenom" name="prenom" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le prénom est vide </span>
								</div>
                                                            
                                                                <div class="form-group has-feedback">
									<label for="lieuNaissance" class="col-lg-3 col-xs-5 col-sm-4 control-label">Lieu de naissance:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="lieuNaissance" class="form-control texte" id="lieuNaissance" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le lieu de naissance est vide</span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label class="col-lg-3 col-xs-5 col-sm-4 control-label"></label>
									<div class="col-lg-8 col-xs-7 col-sm-8 ">
                                                                            <input type="text" class="form-control" style="visibility: hidden;"/>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;"></span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label for="commune" class="col-lg-3 col-xs-5 col-sm-4 control-label">Commune:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
                                                                            <select name="commune" class="form-control" id="commune">
                                                                                <?php
                                                                                foreach ($communes as $commune)
                                                                                {?>
                                                                                <option value="<?php echo $commune['id'];?>"><?php echo $commune['nom'];?></option> 
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;"></span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label for="email" class="col-lg-3 col-xs-5 col-sm-4 control-label">E-amil:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="email" class="form-control" id="email" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">L'adresse mail n'est pas valide</span>
								</div>	
								
                                                                <div class="form-group has-feedback">
									<label for="telephone_contact" class="col-lg-3 col-xs-5 col-sm-4 control-label">Contact:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="telephone_contact" class="form-control" id="telephone_contact" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le numéro n'est pas valide</span>
								</div>	
                                                            
                                                                <div class="form-group has-feedback">
									<label for="responsabilite" class="col-lg-3 col-xs-5 col-sm-4 control-label">Titre / Responsabilite:</label>
									<div class="col-lg-8 col-xs-7 col-sm-8">
										<input type="text" name="responsabilite" class="form-control texte" id="responsabilite" />
										<span class="glyphicon form-control-feedback"></span>
									</div>
									<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">La responsabilite est vide</span>
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
										if(isset($_COOKIE['inscription_personnel']))
										{
											echo $_COOKIE['inscription_personnel']; 
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
		<script src="js/inscription_personnel.js"></script>
	</body>
</html>