<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Résultats</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link rel="icon" href="fonts/glyphicons-halflings-regular.woff" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
				<h1 class="col-lg-4 col-lg-offset-4">Résultats</h1>
				<form class="form-inline col-lg-12">
					<div class="form-group">
						<label class="col-lg-4 control-label" for="classe">Classe:</label>
						<div class="col-lg-8">
							<select name="classe" id="classe" class="form-control">
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
									<option value="<?php echo $classe['id'];?>"><?php echo $libelle;?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-4 control-label" for="trimestre">Trimestre:</label>
						<div class="col-lg-8">
							<select name="trimestre" id="trimestre" class="form-control">
								<option value="1">Premier</option>
								<option value="2">Deuxième</option>
								<option value="3">Troisième</option>
								<option value="4">Annuel</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Classement par ordre de merite</h1>
						</div>
						<div class="table-responsive" id="tableEleve">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Rang</th>
									<th>Moyenne</th>
									<th>Observation</th>
									<th></th>
								</tr>
								
								<?php
								foreach($resultat as $eleve)
								{?>
									<tr class="eleve" id="<?php echo $eleve['matricule'];?>">
										<td><?php echo $eleve['matricule'];?></td>
										<td><?php echo $eleve['nom'];?></td>
										<td><?php echo $eleve['prenom'];?></td>
										<td><?php echo $eleve['rang'];?></td>
										<td><?php echo parseReel($eleve['moyenne']);?></td>
										<td><?php echo $eleve['observation'];?></td>
										<td><a href="bulletin.php?id=<?php echo $eleve['id'];?>">bulletin</a></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/resultats.js"></script>
	</body>
</html>