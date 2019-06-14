<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste personnel</title>
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
		<h1 class="col-lg-4 col-lg-offset-4">Liste du personnel</h1>
		<div class="row saut">
			<div class="col-lg-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title">Liste personnel</h1>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed">
							<tr>
								<th>Matricule</th>
								<th>Nom</th>
								<th>Prénom</th>
								<th>Sexe</th>
								<th>Date de Naissance</th>
								<th>Lieu de Naissance</th>
                                                                <th>Niveau</th>
							</tr>
							
							<?php
							foreach($listePersonnel as $personnel)
							{?>
								<tr class="personnel" id="<?php echo $personnel['matricule'];?>">
									<td><?php echo $personnel['matricule'];?></td>
									<td><?php echo $personnel['nom'];?></td>
									<td><?php echo $personnel['prenom'];?></td>
									<td><?php echo $personnel['sexe'];?></td>
									<td><?php echo $personnel['date_naissance'];?></td>
									<td><?php echo $personnel['lieu_naissance'];?></td>
                                                                        <td><?php echo $personnel['niveau'];?></td>
                                                                        
								</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row saut">
			<div class="col-lg-6 col-sm-6 col-xs-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title">Détail personnel</h1>
					</div>
					
					<div class="panel-body">
						<div id="detail" class="col-lg-10">
							<p><span class="libelle">Matricule: </span><span class="valeur" id="matricule"></span></p>
							<p><span class="libelle">Nom: </span><span class="valeur" id="nom"></span></p>
							<p><span class="libelle">Prénom: </span><span class="valeur" id="prenom"></span></p>
							<p><span class="libelle">Sexe: </span><span class="valeur" id="sexe"></span></p>
							<p><span class="libelle">Date de naissance: </span><span class="valeur" id="dateNaissance"></span></p>
							<p><span class="libelle">Lieu de naissance: </span><span class="valeur" id="lieuNaissance"></span></p>
							<p><span class="libelle">Téléphone: </span><span class="valeur" id="telephone"></span></p>
							<p><span class="libelle">Quartier: </span><span class="valeur" id="quartier"></span></p>
							<p><span class="libelle">Date d'engagement: </span><span class="valeur" id="dateEngagement"></span></p>
							<p><span class="libelle">Fonction: </span><span class="valeur" id="fonction"></span></p>
							<p><span class="libelle">Salaire: </span><span class="valeur" id="salaire"></span></p>
							<p><span class="libelle">Taux horaire: </span><span class="valeur" id="taux"></span></p>
						</div>
						
						<div class="col-lg-2">
							<img src="" alt="PHOTO" id="photo" class="img-responsive"/>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6 col-sm-6 col-xs-12">
				<h1>Attribution classe(s) - Matière(s)</h1>
				<div class="row">
					<form method="post" enctype="multipart/form-data" class="well form-horizontal col-lg-12 col-xs-12 col-sm-12">
						<div class="form-group has-feedback">
							<input type="radio" id="primaire" name="niveau" checked />
							<label for="primaire">Primaire</label>
							
							<input type="radio" id="secondaire" name="niveau" />
							<label for="secondaire">Secondaire</label>
						</div>	
						
						
						<div class="form-group has-feedback">
							<div class="col-lg-5 col-xs-8 col-sm-8">
								<input type="hidden" name="personnel" class="form-control" id="personnel" />
							</div>
						</div>	
						
						<div class="form-group has-feedback">
							<label for="classe" class="col-lg-2 col-xs-4 col-sm-2">Classe:</label>
							<div class="col-lg-5 col-xs-8 col-sm-8">
								<select name="classe" class="form-control" id="classe">
									<?php
									foreach($classePrimaire as $classe)
									{?>
										<option value="<?php echo $classe['id'];?>"><?php echo formatClasse($classe);?></option>
									<?php	
									}
									?>
								</select>
							</div>
						</div>	
						
						<button class="btn btn-success" id="ajouterMatiere" disabled >Ajouter une matère</button>
						
						<div class="panel panel-success">
							<div class="panel-heading">
								<h1 class="panel-title">Matière</h1>
							</div>
							<div class="table-responsive" id="listeMatiere">
								<table class="table table-bordered table-striped table-condensed" id="table">
									<tr>
										<th>Classe</th>
										<th>Matière</th>
									</tr>
								</table>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-4 col-lg-offset-4">
								<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
								<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
							</div>
						</div>
					
					</form>
				</div>
				
				<div class="modal fade" id="modalAjoutMatiere" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title" id="titre-alert">Ajout d'une matière</h1>
							</div>
							<div class="modal-body">
								<form method="post" class="well form-horizontal">
									<div class="form-group has-feedback">
										<label for="classeSecondaire" class="col-lg-2 col-xs-4 col-sm-2">Classe:</label>
										<div class="col-lg-5 col-xs-8 col-sm-8">
											<select name="classeSecondaire" class="form-control" id="classeSecondaire">
												<?php
												foreach($classeSecondaire as $classe)
												{?>
													<option value="<?php echo $classe['id'];?>"><?php echo formatClasse($classe);?></option>
												<?php	
												}
												?>
											</select>
										</div>
									</div>	
									
									<div class="panel panel-success">
										<div class="panel-heading">
											<h1 class="panel-title">Matière</h1>
										</div>
										<div class="table-responsive" id="matiere">
											<table class="table table-bordered table-striped table-condensed">
												<tr>
													<th>Matière</th>
													<th>Ajouter</th>
												</tr>
												
												<?php
												foreach($listeMatiere as $matiere)
												{?>
													<tr id="<?php echo $matiere['id'];?>" class="matiere">
														<td><?php echo $matiere['nom'];?></td>
														<td><input type="checkbox" /></td>
													</tr>
												<?php
												}
												?>
											</table>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-lg-4 col-lg-offset-4">
											<input type="submit" class="btn btn-success" value="Valider" id="validationAjoutMatiere" />
											<input type="reset" class="btn btn-success" value="Annuler" id="annuler" data-dismiss="modal" />
										</div>
									</div>
								
								</form>
							</div>
						</div>
					</div>
				</div>
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
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/liste_personnel.js"></script>
	</body>
</html>