<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Mensualité élève</title>
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
				<h1 class="col-lg-12" style="text-align: center;">Paiement mensualité</h1>
				<div class="row">
					<form method="post" enctype="multipart/form-data" class="well form-horizontal col-lg-7 col-xs-12  col-sm-7">
						<div class="form-group">
							<div class="input-group col-lg-4">
								<input type="text" name="rechercher" id="matriculeRecherche" class="form-control" placeholder="Rechercher un élève" />
								<span class="input-group-btn">
									<button class="btn btn-success" type="button" id="rechercher"><span class="glyphicon glyphicon-search" /></button>
								</span>
							</div>
						</div>
							
						<fieldset>
							<legend>Informations élève</legend>
							<div class="row">
								<div class="col-lg-9">
									<div class="form-group has-feedback">
										<label for="matricule" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matricule:</label>
										<div class="col-lg-5 col-xs-7 col-sm-8">
											<input type="text" class="form-control texte" id="matricule" name="matricule"/>
										</div>
									</div>
									
									<div class="form-group">
										<label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
										<div class="col-lg-8 col-xs-7 col-sm-8">
											<input type="text" class="form-control texte" id="nom" name="nom" />
										</div>
									</div>
									
									<div class="form-group">
										<label for="prenom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Prénom:</label>
										<div class="col-lg-8 col-xs-7 col-sm-8">
											<input type="text" class="form-control texte" id="prenom" name="prenom" />
										</div>
									</div>
									
									<div class="form-group">
										<label for="sexe" class="col-lg-3 col-xs-5 col-sm-4 control-label">Sexe:</label>
										<div class="col-lg-3 col-xs-7 col-sm-8">
											<input type="text" id="sexe" name="sexe" class="form-control" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-3 col-xs-5 col-sm-4 control-label">Niveau:</label>
										<div class="col-lg-4 col-xs-3 col-sm-3">
											<input type="text" class="form-control" id="niveau" />
										</div>
									</div>
								</div>
								
								<div class="col-lg-3">
									<img src="" alt="image" class="img-responsive" id="image" />
								</div>
							</div>
						</fieldset>
					</form>
					
					<form method="post" enctype="multipart/form-data" class="well form-horizontal col-lg-4 col-lg-offset-1 col-xs-12  col-sm-5">
						<fieldset>
							<legend>Mensualité</legend>
							<div class="form-group">
								<label class="col-lg-3 col-xs-5 col-sm-4 control-label">Date:</label>
								<div class="col-lg-3 col-xs-3 col-sm-3">
									<input type="text" class="form-control" id="jourPaie" name="jourPaie" placeholder="JJ" value="<?php echo $jourActuel;?>" />
									<span class="glyphicon form-control-feedback"></span>
								</div>
								
								<div class="col-lg-3 col-xs-3 col-sm-3">
									<input type="text" class="form-control" id="moisPaie" name="moisPaie"  placeholder="MM" value="<?php echo $moisActuel;?>"/>
									<span class="glyphicon form-control-feedback"></span>
								</div>
								
								<div class="col-lg-3 col-xs-3 col-sm-3">
									<input type="text" class="form-control" id="anneePaie" name="anneePaie" placeholder="AAAA" value="<?php echo $anneeActuel;?>" />
									<span class="glyphicon form-control-feedback"></span>
								</div>
								
								<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerDate">La date de naissance n'est pas valide</span>
							
							</div>
										
							<div class="form-group">
								<label for="mois" class="col-lg-5 col-xs-5 col-sm-4 control-label">Mois:</label>
								<div class="col-lg-4 col-xs-7 col-sm-8">
									<select class="form-control" id="mois" name="mois">
										<?php
										for($i=0; $i<count($listeMois); $i++)
										{?>
											<option value="<?php echo $i+1; ?>" <?php if($i+1==$moisActuel) echo 'selected';?>><?php echo $listeMois[$i]; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
<!-- ajouté par JPHN le 12/06/2019 pour permettre de différencier les différents types de frais de scolarités  -->
							<div class="form-group">
								<label for="libelle" class="col-lg-5 col-xs-5 col-sm-4 control-label">Libellé:</label>
								<div class="col-lg-7 col-xs-10 col-sm-11 input-group">
									<select class="form-control" id="libelle" name="libelle">
										<?php
                                                                                $idEcole = $_SESSION['user']['idEcole'];
                                                                                $libelles= getFeeLabels($idEcole);
										foreach($libelles as $libelle)
										{?>
											<option value="<?php echo $libelle['libelle']; ?>"><?php echo $libelle['libelle']; ?></option>
										<?php
										}
										?>
									</select>
                                                                    <span class="input-group-btn flo-right"><button id="addLabel" type="button" class="btn btn-success" value="+"/>+</button></span>
                                                                </div>
							</div>
<!-- fin ajout JPHN -->
							<div class="form-group has-feedback">
								<label for="montant" class="col-lg-5 col-xs-5 col-sm-4 control-label">Montant:</label>
								<div class="col-lg-5 col-xs-7 col-sm-8">
									<input type="text" class="form-control" id="montant" name="montant" />
									<span class="glyphicon form-control-feedback"></span>
								</div>
								<div class="form-group col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le montant n'est pas valide</div>
							</div>
							
							<div class="form-group has-feedback">
								<label for="reduction" class="col-lg-5 col-xs-5 col-sm-4 control-label">Réduction:</label>
								<div class="col-lg-5 col-xs-7 col-sm-8">
									<input type="text" class="form-control" id="reduction" name="reduction" />
									<span class="glyphicon form-control-feedback"></span>
								</div>
								<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le montant de la réduction n'est pas valide</span>
							</div>
							
							<div class="form-group has-feedback">
								<label for="montant" class="col-lg-5 col-xs-5 col-sm-4 control-label">Numéro de reçu :</label>
								<div class="col-lg-4 col-xs-7 col-sm-8">
									<input type="text" class="form-control" id="recu" name="recu" />
									<span class="glyphicon form-control-feedback"></span>
								</div>
								<span class="help-block col-lg-6 col-lg-offset-5 col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le numéro de reçu est vide</span>
							</div>
							
							<div class="form-group">
								<div class="col-lg-4 col-xs-7 col-sm-8">
									<input type="hidden" class="form-control" id="idEleve" name="idEleve" />
								</div>
							</div>
						</fieldset>
						
						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-3">
								<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
								<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
							</div>
						</div>
					</form>
				</div>
					
					<div class="modal fade" id="alert" data-backdrop="false">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">x</button>
									<h1 class="modal-title" id="titre-alert"><?php echo $observation; ?> Mensualité</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['mensualite']))
										{
											echo $_COOKIE['mensualite']; 
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
		<script src="js/mensualite.js"></script>
	</body>
</html>