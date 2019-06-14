<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste des élèves</title>
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
				<h1 class="col-lg-4 col-lg-offset-4">Liste des élèves</h1>
				<form class="form-inline col-lg-12">
					<div class="form-group">
						<label class="col-lg-6 control-label" for="annee">Année Scolaire:</label>
						<div class="col-lg-6">
							<select name="annee" id="annee" class="form-control">
								<?php
								foreach($listeAnnee as $annee)
								{?>
									<option value="<?php echo $annee['annee'];?>"><?php echo $annee['annee'];?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					
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
						<div class="col-lg-1">
							<input type="checkbox" name="afficherTous" id="afficherTous" class="form-control">
						</div>
						<label class="col-lg-9 control-label" for="afficherTous">Afficher tous</label>
					</div>
					
					<div class="form-group">
					<div class="input-group col-lg-12">
						<input type="text" name="rechercher" id="matriculeRecherche" class="form-control" placeholder="Rechercher un étudiant" />
						<span class="input-group-btn">
							<button class="btn btn-success" type="button" id="rechercher"><span  class="glyphicon glyphicon-search" /></button>
						</span>
					</div>
					</div>
				</form>
			</div>
			
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title">Liste des élèves</h1>
						</div>
						<div class="table-responsive" id="tableEleve">
							<table class="table table-bordered table-striped table-condensed">
								<tr>
									<th>Matricule</th>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Sexe</th>
									<th>Date de Naissance</th>
									<th>Lieu de Naissance</th>
									<th>Père</th>
									<th>Mère</th>
								</tr>
								
								<?php
								foreach($listeEleve as $eleve)
								{?>
									<tr class="eleve" id="<?php echo $eleve['matricule'];?>">
										<td><?php echo $eleve['matricule'];?></td>
										<td><?php echo $eleve['nom'];?></td>
										<td><?php echo $eleve['prenom'];?></td>
										<td><?php echo $eleve['sexe'];?></td>
										<td><?php echo $eleve['date_naissance'];?></td>
										<td><?php echo $eleve['lieu_naissance'];?></td>
										<td><?php echo $eleve['pere'];?></td>
										<td><?php echo $eleve['mere'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="detailEleve">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title">Détail élève</h1>
								<button class="close" data-dismiss="modal">x</button>
							</div>
							
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-7">
										<div class="row">
											<h2>Informations personnelles</h2>
											<div class="col-lg-9">
												<p><span class="libelle">Matricule: </span><span class="valeur" id="matricule"></span></p>
												<p><span class="libelle">Nom: </span><span class="valeur" id="nom"></span></p>
												<p><span class="libelle">Prénom: </span><span class="valeur" id="prenom"></span></p>
												<p><span class="libelle">Sexe: </span><span class="valeur" id="sexe"></span></p>
												<p><span class="libelle">Date de naissance: </span><span class="valeur" id="dateNaissance"></span></p>
												<p><span class="libelle">Lieu de naissance: </span><span class="valeur" id="lieuNaissance"></span></p>
												<p><span class="libelle">Père: </span><span class="valeur" id="pere"></span></p>
												<p><span class="libelle">Mère: </span><span class="valeur" id="mere"></span></p>
											</div>
											
											<div class="col-lg-3">
												<img src="" alt="PHOTO" id="photo" class="img-responsive"/>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-5">
												<h2>Tuteur</h2>
												<p><span class="libelle">Nom: </span><span class="valeur" id="nomTuteur"></span></p>
												<p><span class="libelle">Téléphone: </span><span class="valeur" id="telephone"></span></p>
												<p><span class="libelle">Adresse: </span><span class="valeur" id="adresse"></span></p>
											</div>
										</div>
									</div>
									
									<div class="col-lg-5">
										<h2>Cours</h2>
										<p><span class="libelle">Date inscription: </span><span class="valeur" id="dateInscription"></span></p>
										<p><span class="libelle">Classe: </span><span class="valeur" id="coursDemande"></span></p>
										<p><span class="libelle">Ecole d'origine: </span><span class="valeur" id="ecoleOrigine"></span></p>
										<p><span class="libelle">PV dernier examen: </span><span class="valeur" id="pv"></span></p>
										<p><span class="libelle">Rang dernier examen: </span><span class="valeur" id="rang"></span></p>
										<p><span class="libelle">Session dernier examen: </span><span class="valeur" id="session"></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="modalMatricule">
					<div class="modal-dialog">
						<div class="modal-content echec">
							<div class="modal-header">
								<h1 class="modal-title">Rechercher élève</h1>
								<button class="close" data-dismiss="modal">x</button>
							</div>
							
							<div class="modal-body">
								<p>Ce numéro de matricule n'est attribué à aucun élève</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/liste_eleve.js"></script>
	</body>
</html>