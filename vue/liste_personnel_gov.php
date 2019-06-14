<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Liste du personnel</title>
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
                    <h1 class="col-lg-12" style="text-align: center;">Liste du personnel</h1>

                    <div class="row saut">
                        <form method="post" class="form-inline col-lg-12 saut">					
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


                            <div class="form-group has-feedback">
                                <label for="categorie" class="col-lg-4 control-label">Catégorie:</label>
                                <div class="col-lg-5 col-xs-7 col-sm-8">
                                        <select class="form-control texte" id="categorie" name="categorie">
                                        <?php 
                                        foreach($listeCategorie as $categorie)
                                        {?>
                                            <option value="<?php echo $categorie['categorie'];?>"><?php echo $categorie['categorie'];?></option>
                                        <?php
                                        }
                                        ?>
                                        </select>
                                </div>
                            </div>

                        </form>
                        
                        <p><a href="#globale" data-toggle="modal" data-backdrop="false" class="btn btn-success">Statistique Globale</a></p>
                        
                        <div class="modal fade" id="globale">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title">Statistique globale</h1>
                                        <span class="close" data-dismiss="modal">x</span>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <tr>
                                                    <th>Commune</th>
                                                    <?php
                                                    foreach($listeCategorie as $categorie)
                                                    {?>
                                                        <th><?php echo $categorie['categorie'];?></th>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                                for($i=0; $i<count($statistiquesGlobale); $i++)
                                                {?>
                                                <tr>
                                                    <td><?php echo $statistiquesGlobale[$i]['nom'];?></td>
                                                    <?php
                                                    foreach($listeCategorie as $categorie)
                                                    {?>
                                                        <td><?php echo $statistiquesGlobale[$i][$categorie['categorie']];?></td>
                                                    <?php
                                                    }
                                                    ?>
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
                    </div>

                    <div class="row" id="statistique">
                        <?php 
                        foreach ($statistiques as $statistique)
                        {?>
                        <div class="col-lg-3 col-xs-12 col-sm-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h1 class="panel-title"><?php echo $statistique['categorie'];?></h1>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">Femme: <span class="badge succes"><?php echo $statistique['fille'];?></span></li>
                                        <li class="list-group-item">Homme: <span class="badge succes"><?php echo ($statistique['nombre']-$statistique['fille']);?></span></li>
                                        <li class="list-group-item">Total: <span class="badge succes"><?php echo $statistique['nombre'];?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
		
                    <div class="row table-responsive" id="listePersonnel">
                        <table class="table table-bordered table-condensed col-lg-12 col-sm-12 col-xs-12">
                            <tr>
                                <th>Matricule</th>
                                <th>CIN</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Sexe</th>
                                <th>Date Nais</th>
                                <th>Lieu Nais</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Catégorie</th>
                                <th>Responsabilité</th>
                            <tr>

                            <?php
                            foreach ($listePersonnel as $personnel)
                            {?>
                            <tr>
                                <td><?php echo $personnel['matricule'];?></td>
                                <td><?php echo $personnel['cin'];?></td>
                                <td><?php echo $personnel['nom'];?></td>
                                <td><?php echo $personnel['prenom'];?></td>
                                <td><?php echo $personnel['sexe'];?></td>
                                <td><?php echo $personnel['date'];?></td>
                                <td><?php echo $personnel['lieu_naissance'];?></td>
                                <td><?php echo $personnel['adresse'];?></td>
                                <td><?php echo $personnel['telephone'];?></td>
                                <td><?php echo $personnel['email'];?></td>
                                <td><?php echo $personnel['personne_contact'];?></td>
                                <td><?php echo $personnel['categorie'];?></td>
                                <td><?php echo $personnel['titre_responsabilite'];?></td>
                            </tr>
                            <?php  
                            }
                            ?>
                        </table>	
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
		<script src="js/liste_personnel_gov.js"></script>
	</body>
</html>