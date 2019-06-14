<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste des classes</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-4 col-lg-offset-4">Liste des classes</h1>
				<div class="col-lg-5">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Effectif par classe</h1>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Classe</th>
									<th>Total</th>
									<th>Garçon</th>
									<th>Fille</th>
								</tr>
								
								<?php
								foreach($listeClasse as $classe)
								{
								?>
									<tr class="classe" id="<?php echo $classe['id'];?>">
										<td><?php echo formatClasse($classe);?></td>
										<td><?php echo $classe['total'];?></td>
										<td><?php echo $classe['garcon'];?></td>
										<td><?php echo $classe['fille'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-lg-offset-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Effectif total</h1>
						</div>
						
						<div class="panel-body">
							<p><span class="libelle">Total: </span><span class="valeur"><?php echo $effectifTotal['total'];?></span></p>
							<p><span class="libelle">Garçon: </span><span class="valeur"><?php echo $effectifTotal['garcon'];?></span></p>
							<p><span class="libelle">Fille: </span><span class="valeur"><?php echo $effectifTotal['fille'];?></span></p>	
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title" id="titreTableEleve">Liste des élèves <?php echo $libelle;?></h1>
						</div>
						<div class="table-responsive" id="tableEleve">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Sexe</th>
									<th>Date de Naissance</th>
									<th>Lieu de Naissance</th>
									<th>Père</th>
									<th>Mère</th>
								</tr>
								
								<?php
								foreach($listeEleve as $eleve)
								{?>
									<tr>
										<td><?php echo $eleve['matricule'];?></td>
										<td><?php echo $eleve['nom'];?></td>
										<td><?php echo $eleve['prenom'];?></td>
										<td><?php echo $eleve['sexe'];?></td>
										<td><?php echo $eleve['date_naissance'];?></td>
										<td><?php echo $eleve['lieu_naissance'];?></td>
										<td><?php echo $eleve['pere'];?></td>
										<td><?php echo $eleve['mere'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Liste des matières</h1>
						</div>
						<div class="table-responsive" id="tableMatiere">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>N°</th>
									<th>Matière</th>
									<th>Coefficient</th>
								</tr>
								
								<?php
								$i=1;
								foreach($listeMatiere as $matiere)
								{?>
									<tr>
										<td><?php echo $i;?></td>
										<td><?php echo $matiere['nom'];?></td>
										<td><?php echo $matiere['coefficient'];?></td>
									</tr>
								<?php
									$i++;
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<p><button class="btn btn-success" id="etablirEmploie">Etablir un emploie</button></p>
				<div class="col-lg-9">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title" id="titreTableEmploie">Emploie du temps <?php echo $libelle;?></h1>
						</div>
						<div class="table-responsive" id="tableEmploie">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Jour</th>
									<th>Matière</th>
									<th>Enseignant</th>
									<th>Début</th>
									<th>Fin</th>
								</tr>
								
								<?php
								foreach($listeEmploie as $emploie)
								{?>
									<tr>
										<td><?php echo array_search($emploie['jour'], $listeJour);?></td>
										<td><?php echo $emploie['nom_matiere'];?></td>
										<td><?php echo $emploie['nom_pers'].' '.$emploie['prenom'];?></td>
										<td><?php echo $emploie['debut'];?></td>
										<td><?php echo $emploie['fin'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="modalEmploie" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title" id="titre-alert">Etablissement emploie</h1>
							</div>
							
							<div class="modal-body">
								<form method="post" class="form-horizontal" id="formEmploie">
									<div class="form-group">
										<input type="hidden" value="<?php echo $idClasseActif;?>" name="classe" id="classe" />
									</div>
									
									<div class="form-group has-feedback">
										<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Jour:</label>
										<div class="col-lg-9 col-xs-7 col-sm-8">
											<select class="form-control texte" id="jour" name="jour">
											<?php 
											foreach($listeJour as $jour=>$valeur)
											{?>
												<option value="<?php echo $valeur;?>"><?php echo $jour;?></option>
											<?php
											}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group has-feedback">
										<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matière:</label>
										<div class="col-lg-9 col-xs-7 col-sm-8">
											<select class="form-control texte" id="matiere" name="matiere">
											<?php 
											foreach($listeMatiere as $matiere)
											{?>
												<option value="<?php echo $matiere['id'];?>"><?php echo $matiere['nom'];?></option>
											<?php
											}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group has-feedback">
										<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Enseignant:</label>
										<div class="col-lg-9 col-xs-7 col-sm-8">
											<input type="text" class="form-control" id="professeur" name="professeur" />
										</div>
										<div class="col-lg-9 col-lg-offset-3">
											<span class="help-block" id="nomProfesseur"></span>
										</div>
									</div>
									
									<div class="form-group has-feedback">
										<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Début:</label>
										<div class="col-lg-4 col-xs-7 col-sm-8">
											<select class="form-control texte" id="heureDebut" name="heureDebut">
											<?php 
											foreach($listeHeure as $heure)
											{?>
												<option value="<?php echo $heure;?>"><?php echo $heure>9?$heure:'0'.$heure;?></option>
											<?php
											}
											?>
											</select>
										</div>
										
										<div class="col-lg-4 col-xs-7 col-sm-8">
											<select class="form-control texte" id="minuteDebut" name="minuteDebut">
											<?php 
											foreach($listeMinute as $minute)
											{?>
												<option value="<?php echo $minute;?>"><?php echo $minute>9?$minute:'0'.$minute;?></option>
											<?php
											}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group has-feedback">
										<label for="region" class="col-lg-3 col-xs-5 col-sm-4 control-label">Fin:</label>
										<div class="col-lg-4 col-xs-7 col-sm-8">
											<select class="form-control texte" id="heureFin" name="heureFin">
											<?php 
											foreach($listeHeure as $heure)
											{?>
												<option value="<?php echo $heure;?>"><?php echo $heure>9?$heure:'0'.$heure;?></option>
											<?php
											}
											?>
											</select>
										</div>
										
										<div class="col-lg-4 col-xs-7 col-sm-8">
											<select class="form-control texte" id="minuteFin" name="minuteFin">
											<?php 
											foreach($listeMinute as $minute)
											{?>
												<option value="<?php echo $minute;?>"><?php echo $minute>9?$minute:'0'.$minute;?></option>
											<?php
											}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-lg-4 col-lg-offset-4">
											<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
											<input type="reset" class="btn btn-success" value="Annuler" id="annuler" data-dismiss="modal"/>
										</div>
									</div>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/liste_classe.js"></script>
	</body>
</html>