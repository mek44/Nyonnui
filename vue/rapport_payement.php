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
		
		<?php
		if($pageValide)
		{?>
		<div class="container">
			<h1 class="col-lg-12" style="text-align: center;">Rapport des payements</h1>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" enctype="multipart/form-data" class="form-inline col-lg-12">
					<div class="form-group">
						<label class="control-label col-lg-5">Mois</label>
						<div class="col-lg-7">
							<select class="form-control" id="mois">
								<?php 
								foreach ($listeMois as $option=>$valeur) 
								{?>
									<option value="<?php echo $valeur; ?>" <?php if($moisActuel==$valeur) echo 'selected';?>><?php echo $option; ?></option> 
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
									$libelle=$classe['niveau'].' ';
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
							<h1 class="panel-title">Payements effectués</h1>
						</div>
						
						<div class="table-responsive" id="payement">
							<table class="table table-striped table-condensed table-bordered">
								<tr>
									<th>Date</th>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Classe</th>
									<th>Mois</th>
									<th>Payé</th>
									<th>Réduction</th>
									<th>Reçu</th>
								</tr>

								<?php
								foreach ($listePaye as $paye) {
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
									if($paye['niveau']>10)
										$libelle.=$paye['option_lycee'];
								
									$libelle.=$paye['intitule'];
									
									$mois='';
									foreach($listeMois as $nom=>$numero)
									{
										if($numero==$paye['mois'])
										{
											$mois=$nom;
											break;
										}	
									}
								?>
									<tr>
										<td><?php echo $paye['date']; ?></td>
										<td><?php echo $paye['matricule']; ?></td>
										<td><?php echo $paye['nom']; ?></td>
										<td><?php echo $paye['prenom']; ?></td>
										<td><?php echo $libelle; ?></td>
										<td><?php echo $mois; ?></td>
										<td><?php echo formatageMontant($paye['montant']-$paye['reduction']); ?></td>
										<td><?php echo formatageMontant($paye['reduction']); ?></td>
										<td><?php echo $paye['num_recus']; ?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4">
					<p class="total-versement">Total: <span id="total"><?php echo formatageMontant($total); ?></span></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title"></h1>
						</div>
						
						<div class="panel-body">
							<p><span class="libelle">Montant Mensualité: </span><span class="valeur" id="mensualite"><?php echo formatageMontant($total-$cfip);?></span></p>
							<p><span class="libelle">Montant CFIP: </span><span class="valeur" id="cfip"><?php echo formatageMontant($cfip);?></span></p>
							<p><span class="libelle">Assistance Carburant: </span><span class="valeur" id="partEcole"><?php echo formatageMontant($partEcole); ?></span></p>
							<p><span class="libelle">ONG: </span><span class="valeur" id="partOng"><?php echo formatageMontant($partOng);?></span></p>							
						</div>
					</div>
				</div>
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
		<script src="js/rapport_payement.js"></script>
	</body>
</html>