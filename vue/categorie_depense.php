<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Catégorie de dépense</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-4">
					<h3 class="col-lg-12" style="text-align: center;">Ajouter une catégorie</h3>
					<form method="post" action="controle/edition_categorie.php" class="well form-horizontal col-lg-12 col-xs-12 col-sm-12 col-md-12">
						<div class="form-group has-feedback">
							<label for="libelle" class="col-lg-3 col-xs-5 col-sm-4 control-label">Libellé:</label>
							<div class="col-lg-8 col-xs-7 col-sm-8">
								<input type="text" name="libelle" id="libelle" class="form-control" />
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-8 col-lg-offset-4">
								<input type="submit" class="btn btn-success" name="ajouter" value="Valider" id="envoyer" />
								<input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
							</div>
						</div>
					</form>
				</div>
				
				
				<div class="col-lg-5 col-lg-offset-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Liste des catégories</h1>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed">
								<tr class="entete-table">
									<th>Nom</th>
									<th style="width: 5%;">Modifier</th>
								</tr>
								
								<?php
								foreach($listeCategories as $categorie)
								{?>
									<tr class="categorie" id="<?php echo $categorie['id'];?>">
										<td><?php echo $categorie['libelle'];?></td>
										<td><span class="glyphicon glyphicon-edit edit-categorie" id="editcategorie-<?php echo $categorie['id'];?>"></span></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
					
					<div class="modal fade" id="edition" data-backdrop="false">
						<div class="modal-dialog">
							<div class="modal-content modal-sm">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">x</button>
									<h3 class="modal-title">Edition Catégorie</h3>
								</div>
								
								<div class="modal-body">
									<form method="post" action="controle/edition_categorie.php" class="form-horizontal">
										<div class="form-group">
											<input type="hidden" name="id" id="idEdit">
										</div>
										
										<div class="form-group has-feedback">
											<label for="editLibelle" class="col-lg-3 col-xs-5 col-sm-4 control-label">Libellé:</label>
											<div class="col-lg-8 col-xs-7 col-sm-8">
												<input type="text" name="libelle" id="editLibelle" class="form-control" />
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-lg-8 col-lg-offset-4">
												<input type="submit" class="btn btn-success" name="editer" value="Modifier"/>
												<input type="reset" class="btn btn-success" value="Fermer"  data-dismiss="modal"/>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/categorie_depense.js"></script>
	</body>
</html>