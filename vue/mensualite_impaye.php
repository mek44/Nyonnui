<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Mensualité élève</title>
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
			<h1 class="col-lg-12" style="text-align: center;">Les scolarités impayées</h1>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" enctype="multipart/form-data" class="form-inline col-lg-12">
					<div class="form-group">
						<label class="control-label col-lg-5">Mois</label>
						<div class="col-lg-7">
							<select class="form-control" id="mois">
								<option value="0">Tous</option> 
								<?php 
								foreach ($listeMois as $option=>$valeur) 
								{?>
									<option value="<?php echo $valeur; ?>"><?php echo $option; ?></option> 
								<?php
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-4">Classe</label>
						<div class="col-lg-8">
							<select name="classe" id="classe" class="form-control">
								<option value="0">Toutes</option>
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
				</form>
			</div>
				
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Résultats de la recherche</h1>
						</div>
						
						<div class="table-responsive" id="versement">
							<table class="table table-striped table-condensed table-bordered">
								<tr>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Sexe</th>
									<th>Classe</th>
								</tr>

								<?php
								foreach ($listeImpayees as $impayee)
                                                                {
								?>
									<tr>
										<td><?php echo $impayee['matricule']; ?></td>
										<td><?php echo $impayee['nom']; ?></td>
										<td><?php echo $impayee['prenom']; ?></td>
										<td><?php echo $impayee['sexe']; ?></td>
                                                                                <td><?php echo formatClasse($impayee); ?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
                <?php
                }
                else
                {?>
                        <p>Vous n'avez pas à cette page</p>
                <?php
                }
                ?>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/mensualite_impayee.js"></script>
	</body>
</html>