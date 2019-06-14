<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Statistique de présence</title>
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
			<h1 class="col-lg-12" style="text-align: center;">Statistique de présence <?php echo $nomEcole;?></h1>
			<p><a href="<?php echo $lienTaux;?>" class="btn btn-success">Voir le taux de présence par mois</a></p>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" class="form-inline col-lg-10 col-xs-12 col-sm-10">
					<div class="form-group">
						<label class="control-label">Date:</label>
							
						<input type="text" id="jour" name="jour" placeholder="JJ" size="2" value="<?php echo $jour;?>" class="form-control" />
						
						<input type="text" id="mois" name="mois"  placeholder="MM" size="2" value="<?php echo $mois;?>" class="form-control" />
						
						<input type="text" id="annee" name="annee" placeholder="AAAA" size="3" value="<?php echo $annee;?>" class="form-control" />
						
					</div>
					
					<input type="hidden" value="<?php echo $idEcole;?>" id="idEcole" />
					<button class="btn btn-success" id="actualiser">Actualiser</button>
				</form>
			</div>
				
			<div class="row" id="statistique">
				<?php
				foreach($statistique as $classe)
				{
                                    
                                    if($_SESSION['user']['nom_fonction']=='Enseignant' && !in_array($classe['id'], $classeEnseignant)){
                                        continue;
                                    }
				?>
                                    <div class="col-lg-3">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo formatClasse($classe); ?></h1>
                                            </div>
                                            <div class="panel-body">
                                                <ul class="list-group">
                                                        <li class="list-group-item">Effectif: <span class="badge succes"><?php echo $classe['effectif'];?></span></li>
                                                        <li class="list-group-item">Garçons: <span class="badge succes"><?php echo $classe['garcon'];?></span></li>
                                                        <li class="list-group-item">Filles: <span class="badge succes"><?php echo $classe['fille'];?></span></li>
                                                </ul>

                                                <ul class="list-group">
                                                        <li class="list-group-item">Présent(s): <span class="badge succes"><?php echo $classe['effectif']-$classe['absent'];?></span></li>
                                                        <li class="list-group-item">Absent(s): <span class="badge succes"><?php echo $classe['absent'];?></span></li>
                                                        <li class="list-group-item">Fille(s) Absente(s): <span class="badge succes"><?php echo $classe['fille_absent'];?></span></li>
                                                        <li class="list-group-item">Garçon(s) Absent(s): <span class="badge succes"><?php echo $classe['absent']-$classe['fille_absent'];?></span></li>

                                                </ul>

                                                <p><button class="btn btn-success btn-block afficherAbsent" id="<?php echo $classe['id']; ?>">Afficher les absents</button></p>
                                            </div>
                                        </div>
                                    </div>
				<?php
				}
				?>
				
			</div>
			
			
			<div class="modal fade" id="alertAbsent" data-backdrop="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">x</button>
							<h1 class="modal-title" id="titreAbsent">Liste des absents</h1>
						</div>
						
						<div class="modal-body" id="listeAbsent">
							
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
		<script src="js/statistique_presence.js"></script>
	</body>
</html>