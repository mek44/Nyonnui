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
                    <?php
                    if($pageValide)
                    {?>
			<h1 class="col-lg-12" style="text-align: center;">Contrôle de présence</h1>
			<div class="row" style="margin-bottom: 20px;">
				<form method="post" class="form-inline col-lg-10 col-xs-12 col-sm-10">
					<div class="form-group">
                                            <label class="control-label">Date:</label>

                                            <input type="text" id="jour" name="jour" placeholder="JJ" size="2" value="<?php echo $jour;?>" class="form-control" />

                                            <input type="text" id="mois" name="mois"  placeholder="MM" size="2" value="<?php echo $mois;?>" class="form-control" />

                                            <input type="text" id="annee" name="annee" placeholder="AAAA" size="3" value="<?php echo $annee;?>" class="form-control" />
						
					</div>
                                    
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Période</label>
                                            <div class="col-lg-2">
                                                <select name="periode" id="periode" class="form-control">
                                                    <?php
                                                    foreach ($periodes as $periode)
                                                    {?>
                                                    <option><?php echo $periode['debut'].' - '.$periode['fin'];?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

					<div class="form-group">
						<label class="control-label col-lg-3">Classe</label>
						<div class="col-lg-2">
							<select name="classe" id="classe" class="form-control">
								<?php
								foreach($listeClasse as $classe)
								{
									/*$libelle='';
									if($classe['niveau']!=13)
									{
										$libelle=$classe['niveau'];
										if($classe['niveau']==1)
											$libelle.='ère ';
										else
											$libelle.='ème ';
									}
									else
										$libelle='Terminal';
									
									if($classe['niveau']>10)
										$libelle.=$classe['option_lycee'];
								
									$libelle.=$classe['intitule'];*/
								?>
                                                            <option value="<?php echo $classe['id'];?>"><?php echo formatClasse($classe);?></option>
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
							<h1 class="panel-title">Liste des élèves</h1>
						</div>
						
						<div class="table-responsive" id="listeEleve">
							<table class="table table-condensed table-bordered">
								<tr>
									<th style="width: 15%">Nom</th>
									<th style="width: 30%">Prénom</th>
									<th style="width: 5%">Présent</th>
									<th style="width: 50%">Motif</th>
								</tr>

								<?php
								foreach ($listeEleve as $eleve)
								{?>
									<tr class="eleve" id="<?php echo $eleve['id'];?>">
										<td><?php echo $eleve['nom']; ?></td>
										<td><?php echo $eleve['prenom']; ?></td>
										<td><input type="checkbox" <?php if($eleve['present']==1) echo 'checked'; ?> /></td>
										<td><input type="text" name="motif" class="form-controle" style="width: 100%" value="<?php echo $eleve['motif']; ?>" /></td>
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
                    <?php
                    }
                    else
                    {?>
                        <p>Vous n'avez pas accès à cette page</p> 
                    <?php
                    }
                    ?>
		</div>
		
            
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/controle_presence.js"></script>
	</body>
</html>