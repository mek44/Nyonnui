<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ecole Partenaires</title>
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
			<h1 class="col-lg-12" style="text-align: center;">Liste des Ecoles</h1>
			
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" class="form-inline col-lg-12">
					<?php
					if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='Partenaire')
					{?>
					<div class="form-group has-feedback">
						<label for="region" class="col-lg-3 control-label">Département:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select class="form-control texte" id="region" name="region">
							<?php 
							foreach($listeRegion as $region)
							{?>
								<option value="<?php echo $region['id'];?>"><?php echo $region['nom'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<?php
					}
					?>
					
					<?php
					if($_SESSION['user']['nom_fonction']!='DPE / DCE')
					{?>
					<div class="form-group has-feedback">
						<label for="prefecture" class="col-lg-4 control-label">Commune:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select class="form-control texte" id="prefecture" name="prefecture">
							<?php 
							foreach($listePrefecture as $prefecure)
							{?>
								<option value="<?php echo $prefecure['id'];?>"><?php echo $prefecure['nom'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<?php
					}
					else
					{?>
						<select class="form-control texte" id="prefecture" name="prefecture" style="display: none;">
							<option value="<?php echo $_SESSION['user']['id_prefecture']; ?>"><?php echo $_SESSION['user']['id_prefecture']; ?></option>
						</select>
					<?php
					}
					?>

					<div class="form-group has-feedback">
						<label for="cycle" class="col-lg-4 control-label">Cycle:</label>
						<div class="col-lg-5 col-xs-7 col-sm-8">
							<select class="form-control texte" id="cycle" name="cycle">
							<?php 
							foreach($listeCycle as $cycle)
							{?>
								<option value="<?php echo $cycle['id'];?>"><?php echo $cycle['libelle'];?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
				</form>
			</div>

			<div class="row" id="statistique">
				<div class="col-lg-2 col-lg-offset-3 col-xs-12 col-sm-2 col-sm-offset-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Primaire</h1>
						</div>
						<div class="panel-body">
							<ul class="list-group">
								<?php
								$total=0;
								foreach ($primaire as $etablissement) 
								{?>
									<li class="list-group-item"><?php echo $etablissement['etablissement'];?>: <span class="badge succes"><?php echo $etablissement['nombre'];?></span></li>
								<?php
									$total+=$etablissement['nombre'];
								}
								?>
								<li class="list-group-item">Total: <span class="badge succes"><?php echo $total;?></span></li>
							</ul>
							
						</div>
					</div>
				</div>


				<div class="col-lg-2 col-xs-12 col-sm-2">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Collège</h1>
						</div>
						<div class="panel-body">
							<ul class="list-group">
								<?php
								$total=0;
								foreach ($college as $etablissement) 
								{?>
									<li class="list-group-item"><?php echo $etablissement['etablissement'];?>: <span class="badge succes"><?php echo $etablissement['nombre'];?></span></li>
								<?php
									$total+=$etablissement['nombre'];
								}
								?>
								<li class="list-group-item">Total: <span class="badge succes"><?php echo $total;?></span></li>
							</ul>
							
						</div>
					</div>
				</div>


				<div class="col-lg-2 col-xs-12 col-sm-2">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Lycée</h1>
						</div>
						<div class="panel-body">
							<ul class="list-group">
								<?php
								$total=0;
								foreach ($lycee as $etablissement) 
								{?>
									<li class="list-group-item"><?php echo $etablissement['etablissement'];?>: <span class="badge succes"><?php echo $etablissement['nombre'];?></span></li>
								<?php
									$total+=$etablissement['nombre'];
								}
								?>
								<li class="list-group-item">Total: <span class="badge succes"><?php echo $total;?></span></li>
							</ul>
							
						</div>
					</div>
				</div>
			</div>
		
			<div class="row" id="listeEcole">
				<h1>Liste des écoles</h1>
			<?php
			foreach($listeEcole as $ecole)
			{
			?>
				
			<div class="col-lg-3 col-xs-12 col-sm-4">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title"><?php echo $ecole['nom']; ?></h1>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item">Département: <?php echo $ecole['nom_region'];?></li>
							<li class="list-group-item">Commune: <?php echo $ecole['nom_pref'];?></li>
							<li class="list-group-item">Adresse: <?php echo $ecole['adresse'];?></li>
							<li class="list-group-item">Téléphone: <?php echo $ecole['telephone'];?></li>
							<li class="list-group-item">Effectif: <span class="badge succes"><?php echo $ecole['effectif'];?></span></li>
							<li class="list-group-item">Garçon(s): <span class="badge succes"><?php echo $ecole['garcon'];?></span></li>
							<li class="list-group-item">Fille(s): <span class="badge succes"><?php echo $ecole['fille'];?></span></li>
						</ul>
						
						<p><a class="btn btn-success btn-block afficherStatistique" href="statistique_presence.php?id_ecole=<?php echo $ecole['id']; ?>">Statistiques des élèves</a></p>
						<a href="modifier_ecole.php?id=<?php echo $ecole['id']; ?>" class="btn btn-success">Modifier</a>
					</div>
				</div>
			</div>
			<?php
			}
			?>
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
		<script src="js/partenaires.js"></script>
	</body>
</html>