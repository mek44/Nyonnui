<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Modification classe</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12" style="text-align: center;">Modification classe</h1>
				<form method="post" class="well form-horizontal col-lg-12 col-xs-12 col-sm-12">
					<div class="form-group">
						<label for="listeClasse" class="col-lg-1 col-xs-5 col-sm-4 control-label">Classe:</label>
						<div class="col-lg-4 col-xs-7 col-sm-8">
							<select id="listeClasse" name="listeClasse" class="form-control">
								<?php
								foreach($listeClasse as $classe)
								{
                                                                    $libelleClasse=$classe['niveau'].' ';
/*	if($classe['niveau']!=13)
	{
		$libelleClasse=$classe['niveau'];
		if($classe['niveau']==1)
			$libelleClasse.='ère ';
		else
			$libelleClasse.='ème ';
	}
	else
		$libelleClasse='Terminal';
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
				</form>
				
				<div class="col-lg-8">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Liste des matières</h1>
						</div>
					
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed" id="tableMatiere">
								<tr>
									<th>N°</th>
									<th>Matière</th>
									<th>Coefficient</th>
									<th>Modifier</th>
									<th>Supprimer</th>
								</tr>
								
								<?php
								$i=1;								
								foreach($matiereClasse as $matiere)
								{?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $matiere['nom']; ?></td>
									<td><?php echo $matiere['coefficient']; ?></td>
									<td style="text-align:center;"><span class="glyphicon glyphicon-edit edit-matiere" id="editMatiere-<?php echo $matiere['id']; ?>"></span></td>';
									<td style="text-align:center;"><span class="glyphicon glyphicon-remove remove-matiere" id="removeMatiere-<?php echo $matiere['id']; ?>"></span></td>';
								</tr>
								<?php
									$i++;	
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				
				<form method="post" action="modele/ajouter_matiere_classe.php" class="col-lg-4 form-horizontal well" id="formAddMatiere">
					<h2>Ajouter une matière</h2>
					<div class="form-group">
						<label for="matiere" class="col-lg-3 col-xs-5 col-sm-4 control-label">Matière:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
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
					
					<div class="form-group has-feedback">
						<label for="coefficient" class="col-lg-3 col-xs-2 col-sm-4 control-label">Coefficient:</label>
						<div class="col-lg-4 col-xs-7 col-sm-8">
							<input type="text" class="form-control coefficient" id="coefficient" name="coefficient" value="1" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-8 col-xs-10 col-lg-offset-3 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display: none">Le coefficient n'est pas valide</span>
					</div>
					
					<div class="form-group has-feedback">
						<input type="hidden" class="form-control" id="classe" name="classe" value="<?php echo $listeClasse[0]['id'];?>"/>
					</div>
					
					<div class="form-group">
						<div class="col-lg-6 col-lg-offset-3">
							<input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
							<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
						</div>
					</div>
				</form>
				
				<div class="modal fade" id="alert" data-backdrop="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title" id="titre-alert">Ajout matière</h1>
							</div>
							<div class="modal-body">
								<p id="texte-alert">Les données ne sont pas valides</p>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="modal fade" id="modalSuppression" data-backdrop="false">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title">Suppression matière</h1>
							</div>
							<div class="modal-body">
								<form method="post" action="modele/modifier_classe.php" id="suppression" class="form-horizontal">
									<p>Voulez vous vraiment supprimer cette matière</p>
									
									<div class="form-group has-feedback">
										<input type="hidden" class="form-control" id="matiereASupprimer" name="matiereASupprimer" />
									</div>
		
									<div class="form-group has-feedback">
										<input type="hidden" class="form-control" id="classeASupprimer" name="classeASupprimer" value="<?php echo $listeClasse[0]['id'];?>" />
									</div>
									
									<div class="form-group">
										<div class="col-lg-10 col-lg-offset-2">
											<input type="submit" class="btn btn-success" value="Valider" id="validerSuppression" />
											<input type="reset" class="btn btn-success" value="Annuler" id="annulerSuppression" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="modal fade" id="modalModification" data-backdrop="false">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">x</button>
								<h1 class="modal-title">Modification matière</h1>
							</div>
							<div class="modal-body">
								<form method="post" action="modele/modifier_classe.php" id="modification" class="form-horizontal">
									<div class="form-group has-feedback">
										<label for="coefficientAmodifier" class="col-lg-4 col-xs-2 col-sm-4 control-label">Coefficient:</label>
										<div class="col-lg-4 col-xs-7 col-sm-8">
											<input type="text" class="form-control coefficient" id="coefficientAModifier" name="coefficientAModifier" value="1" />
											<span class="glyphicon form-control-feedback"></span>
										</div>
										<span class="help-block col-lg-8 col-xs-10 col-lg-offset-3 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display: none">Le coefficient n'est pas valide</span>
									</div>
									
									<div class="form-group has-feedback">
										<input type="hidden" class="form-control" id="matiereAModifier" name="matiereAModifier" />
									</div>
						
									<div class="form-group has-feedback">
										<input type="hidden" class="form-control" id="classeAModifier" name="classeAModifier" value="<?php echo $listeClasse[0]['id'];?>" />
									</div>
									
									<div class="form-group">
										<div class="col-lg-10 col-lg-offset-2">
											<input type="submit" class="btn btn-success" value="Valider" id="validerModification" />
											<input type="reset" class="btn btn-success" value="Annuler" id="annulerModification" />
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
		<script src="js/modifier_classe.js"></script>
	</body>
</html>