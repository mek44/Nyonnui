<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouvelle classe</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px;">
				<h1 class="col-lg-12" style="text-align: center;">Nouvelle classe</h1>
				<form method="post" action="nouvelle_classe.php" enctype="multipart/form-data" class="well form-horizontal col-lg-4 col-lg-offset-4 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-inscription">
					<div class="form-group has-feedback">
						<label for="niveau" class="col-lg-3 col-xs-5 col-sm-4 control-label">Niveau:</label>
						<div class="col-lg-4 col-xs-7 col-sm-8">
							<select name="niveau" id="niveau" class="form-control">
								<option value=""></option>
								<option value="1">Maternelle</option>
								<option value="2">CI</option>
								<option value="3">CP</option>
								<option value="4">CE</option>
								<option value="5">CM</option>
								<option value="6">6<sup>ème</sup></option>
								<option value="7">5<sup>ème</sup></option>
								<option value="8">4<sup>ème</sup></option>
								<option value="9">3<sup>ème</sup></option>
								<option value="10">2<sup>nde</sup></option>
								<option value="11">1<sup>ère</sup></option>
								<option value="12">T<sup>le</sup></option>
							</select>
						</div>
					</div>
					
					<div class="form-group has-feedback">
						<label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Option:</label>
						<div class="col-lg-4 col-xs-7 col-sm-8">
							<select id="option" name="option" class="form-control">
                                <option value=""></option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F<option>
								<option value="F1">F1<option>
								<option value="F2">F2<option>
								<option value="F3">F3<option>
								<option value="F4">F4<option>
								<option value="F5">G</option>
								<option value="G1">G1</option>
								<option value="G2">G2</option>
								<option value="G3">G3</option>
							</select>
						</div>
					</div>
					
					<div class="form-group has-feedback">
						<label for="libelle" class="col-lg-3 col-xs-5 col-sm-4 control-label">Libellé:</label>
						<div class="col-lg-8 col-xs-7 col-sm-8">
							<input type="text" class="form-control" id="libelle" name="libelle" />
							<span class="glyphicon form-control-feedback"></span>
						</div>
						<span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPrenom">Le prénom est vide </span>
					</div>
					
					
					<div class="form-group">
						<div class="col-lg-8 col-lg-offset-4">
							<input type="submit" class="btn btn-primary" value="Valider" id="envoyer" />
							<input type="reset" class="btn btn-primary" value="Annuler" id="annuler" />
						</div>
					</div>
					
					<div class="modal fade" id="alert" data-backdrop="false">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">x</button>
									<h1 class="modal-title">Nouvelle classe</h1>
								</div>
								<div class="modal-body">
									<p id="texte-alert">
									<?php 
										if(isset($_COOKIE['nouvelle_classe']))
										{
											echo $_COOKIE['nouvelle_classe']; 
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
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/nouvelle_classe.js"></script>
	</body>
</html>