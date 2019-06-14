<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Bulletin</title>
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
				<h1 class="col-lg-4 col-lg-offset-4">Bulletin de note</h1>
				<form class="form-inline col-lg-8 col-lg-offset-2">
					<div class="form-group">
						<label class="col-lg-4 control-label" for="annee">Année:</label>
						<div class="col-lg-8">
							<select name="annee" id="annee" class="form-control">
								<?php
								foreach($listeAnnee as $annee)
								{?>
									<option value="<?php echo $annee['annee']; ?>"><?php echo $annee['annee']; ?></option>
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
				<div class="col-lg-4 col-lg-offset-2">
					<p>Matricule: <span class="valeur"><?php echo $eleve['matricule']; ?></span></p>
					<p>Nom: <span class="valeur"><?php echo $eleve['nom']; ?></span></p>
					<p>Prénom: <span class="valeur"><?php echo $eleve['prenom']; ?></span></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Bulletin de note <?php echo $libelleClasse; ?> Trimestre <?php echo $trimestre; ?></h1>
						</div>
						<div class="table-responsive" id="tableNote">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
								<?php
								foreach($titre as $element)
								{?>
									<th><?php echo $element; ?></th>
								<?php
								}
								?>
								</tr>
								
								<?php
								$i=1;
								foreach($resultat as $matiere)
								{

									?>
									<tr class="eleve">
										<td><?php echo $i; ?></td>
										<td><?php echo $matiere['nom'];?></td>
										
									<?php
									if($niveau>=7)
									{?>
										<td><?php echo $matiere['coefficient'];?></td>
									<?php
									}
									?>
										
									<?php
									for($j=1; $j<=$nombreMois; $j++)
									{?>
										<td><?php echo parseReel($matiere['note'.$j]);?></td>
									<?php
									}
									?>									
										<td><?php echo parseReel($matiere['moyenne']);?></td>
										<td><?php echo $matiere['observation'];?></td>
									</tr>
								<?php
									$i++;
								}
								?>
								<tr>
									<td></td>
									<td></td>
									<?php
									if($niveau>=7)
									{?>
										<td></td>
									<?php
									}
									?>
									
									<?php
									foreach($totalMois as $element)
									{?>
										<td><?php echo parseReel($element/$coefficientTotal); ?></td>
									<?php
									}
									?>
									
									<td><?php echo parseReel($moyenneGenerale); ?></td>
									<td><?php echo $observation; ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-lg-offset-2">
					<p>Moyenne: <span id="moyenne"><?php echo parseReel($moyenneGenerale); ?></span></p>
					<p>Rang: <span id="rang"><?php echo $rang; ?></span></p>
				</div>
			</div>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bulletin.js"></script>
	</body>
</html>