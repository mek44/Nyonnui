<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Saisie des notes</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12 saut" style="text-align: center;">Saisie des notes</h1>
				<form method="post" class="form-inline col-lg-10 col-lg-offset-1 saut" id="form-saisie">
					<div class="form-group">
						<label for="classe" class="col-lg-3 col-xs-5 col-sm-4">Classe:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select id="classe" name="classe" class="form-control">
							<?php
							foreach($listeClasse as $classe)
							{
								$libelle==$classe['niveau'].'';
/*								if($classe['niveau']!=13)
								{
									$libelle=$classe['niveau'];
									if($classe['niveau']==1)
										$libelle.='ère ';
									else
										$libelle.='ème ';
								}
								else
									$libelle='Terminal';
*/								
								if($classe['niveau']>10)
									$libelle.=$classe['option_lycee'];
							
								$libelle.=$classe['intitule'];
							?>
								<option value="<?php echo $classe['id']; ?>"><?php echo $libelle; ?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="matiere" class="col-lg-4 col-xs-5 col-sm-4">Matiere:</label>
						<div class="col-lg-7 col-xs-7 col-sm-8">
							<select id="matiere" name="matiere" class="form-control">
							<?php
							foreach($listeMatiere as $matiere)
							{?>
								<option value="<?php echo $matiere['id']; ?>"><?php echo $matiere['nom']; ?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="mois" class="col-lg-3">Mois:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select id="mois" name="mois" class="form-control">
							<?php
							foreach($listeMois as $cle=>$valeur)
							{?>
								<option value="<?php echo $valeur; ?>"><?php echo $cle; ?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
				</form>
				
				
				<div class="table-responsive col-lg-10 col-lg-offset-1" id="listeEleve">
					<table class="table table-bordered table-striped table-condensed">
						<tr>
							<th>Matricule</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Note</th>
						</tr>
						
						<?php
						foreach($listeEleve as $eleve)
						{?>
							<tr class="eleve">
								<td id="<?php echo $eleve['matricule'];?>"><?php echo $eleve['matricule'];?></td>
								<td><?php echo $eleve['nom'];?></td>
								<td><?php echo $eleve['prenom'];?></td>
								<td><input type="text" value="<?php echo str_replace('.', ',', $eleve['note']);?>" /></td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>
				
				<div class="col-lg-4 col-lg-offset-4">
					<button type="button" class="btn btn-success" id="enregistrer">Enregistrer</button>
					<button type="button" class="btn btn-success" id="annuler">Annuler</button>
				</div>
				
				<div class="modal fade" id="alert" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title">Enregistrement des notes</h1>
							</div>
							<div class="modal-body">
								<p id="texte-alert">Enregistrement en cours...</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/saisie_note.js"></script>
	</body>
</html>