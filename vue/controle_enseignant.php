<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Contrôle de présence</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<h1 class="col-lg-12" style="text-align: center;">Contrôle de présence des enseigants</h1>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" class="form-inline col-lg-10 col--xs-12 col-sm-10">
					<div class="form-group">
						<label class="control-label">Date:</label>
							
						<input type="text" id="jour" name="jour" placeholder="JJ" size="2" value="<?php echo $jour;?>" class="form-control date" />
					
						<input type="text" id="mois" name="mois"  placeholder="MM" size="2" value="<?php echo $mois;?>" class="form-control date" />
					
						<input type="text" id="annee" name="annee" placeholder="AAAA" size="3" value="<?php echo $annee;?>" class="form-control date" />
						
					</div>	
				</form>
			</div>
				
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Emploie</h1>
						</div>
						
						<div class="table-responsive" id="listeEnseignant">
							<table class="table table-condensed table-bordered">
								<tr>
									<th style="width: 25%">Enseignant</th>
									<th style="width: 10%">Classe</th>
									<th style="width: 15%">Matière</th>
									<th style="width: 5%">Début</th>
									<th style="width: 5%">Fin</th>
									<th style="width: 5%">Présent</th>
									<th style="width: 30%">Motif</th>
								</tr>

								<?php
								foreach ($listeControle as $controle)
								{?>
									<tr class="enseignant" id="<?php echo $controle['id'];?>">
										<td><?php echo $controle['nom'].' '.$controle['prenom']; ?></td>
										<td id="<?php echo $controle['id_classe'];?>"><?php echo formatClasse($controle); ?></td>
										<td id="<?php echo $controle['id_matiere'];?>"><?php echo $controle['nom_matiere']; ?></td>
										<td><?php echo $controle['debut']; ?></td>
										<td><?php echo $controle['fin']; ?></td>
										<td><input type="checkbox" <?php if($controle['present']==1) echo 'checked'; ?> /></td>
										<td><input type="text" name="motif" class="form-controle" style="width: 100%" value="<?php echo $controle['motif']; ?>" /></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-lg-offset-4">
					<button type="button" class="btn btn-success" id="enregistrer">Enregistrer</button>
					<button type="button" class="btn btn-success">Annuler</button>
				</div>
				
				
				<div class="modal fade" id="alert" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title">Enregistrement du contrôle</h1>
							</div>
							<div class="modal-body">
								<p id="texte-alert">Enregistrement en cours...</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/controle_enseignant.js"></script>
	</body>
</html>