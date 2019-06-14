<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouvelle école</title>
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
                    <div class="row" style="margin-top: 20px;">
                            <h1 class="col-lg-12" style="text-align: center;">Nouvelle école</h1>
                            <form method="post" class="well form-horizontal col-lg-6 col-lg-offset-3 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1" id="form-inscription">
                                    <?php
                                    if($_SESSION['user']['nom_fonction']=='Super Administrateur')
                                    {?>
                                    <div class="form-group">
                                        <label for="ecole" class="col-lg-3 col-xs-5 col-sm-4 control-label">Département:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
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
                                    else
                                    {?>
                                    <div class="form-group has-feedback">
                                        <input type="hidden" class="form-control texte" id="region" name="region" value="<?php echo $_SESSION['user']['id_region'];?>" />	
                                    </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($_SESSION['user']['nom_fonction']=='Super Administrateur')
                                    {?>
                                    <div class="form-group">
                                        <label for="prefecture" class="col-lg-3 col-xs-5 col-sm-4 control-label">Commune:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
                                                <select class="form-control texte" id="prefecture" name="prefecture">
                                                <?php 
                                                foreach($listePrefecture as $prefecture)
                                                {?>
                                                        <option value="<?php echo $prefecture['id'];?>"><?php echo $prefecture['nom'];?></option>
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
                                    <div class="form-group">
                                        <input type="hidden" class="form-control texte" id="prefecture" name="prefecture" value="<?php echo $_SESSION['user']['id_prefecture'];?>" />	
                                    </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="form-group has-feedback">
                                        <label for="nom" class="col-lg-3 col-xs-5 col-sm-4 control-label">Nom:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
                                                <input type="text" class="form-control texte" id="nom" name="nom" />
                                                <span class="glyphicon form-control-feedback"></span>
                                        </div>
                                        <span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 2 caractères</span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Adresse:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
                                                <input type="text" class="form-control texte" id="adresse" name="adresse" />
                                                <span class="glyphicon form-control-feedback"></span>
                                        </div>
                                        <span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le nom doit contenir au mois 5 caractères</span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="telephone" class="col-lg-3 col-xs-5 col-sm-4 control-label">Téléphone:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
                                                <input type="text" class="form-control texte" id="telephone" name="telephone" />
                                                <span class="glyphicon form-control-feedback"></span>
                                        </div>
                                        <span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerNom">Le numéro de téléphone est incorrect</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="etablissement" class="col-lg-3 col-xs-5 col-sm-4 control-label">Etablisement:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
                                                <select class="form-control texte" id="etablissement" name="etablissement">
                                                <?php 
                                                foreach($listeEtablissement as $etablissement)
                                                {?>
                                                        <option value="<?php echo $etablissement['id'];?>"><?php echo $etablissement['libelle'];?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cycle" class="col-lg-3 col-xs-5 col-sm-4 control-label">Cycle:</label>
                                        <div class="col-lg-9 col-xs-7 col-sm-8">
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

                                    <?php
                                    if($_SESSION['user']['nom_fonction']=='Super Administrateur')
                                    {?>
                                        <div class="form-group">
                                            <div class="col-lg-9 col-xs-7 col-sm-8 col-lg-offset-3 col-xs-offset-5 col-sm-offset-4">
                                                <input type="checkbox" name="cfip" id="cfip" />
                                                <label for="cfip">CFIP</label>
                                            </div>
                                        </div>
                                
                                        <div class="form-group has-feedback">
                                            <label for="partOng" class="col-lg-3 col-xs-5 col-sm-4 control-label">Part ONG:</label>
                                            <div class="col-lg-9 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control texte" id="partOng" name="partOng" />
                                                    <span class="glyphicon form-control-feedback"></span>
                                            </div>
                                            <span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPartOng">La part de l'ONG n'est pas valide</span>
                                        </div>
                                
                                        <div class="form-group has-feedback">
                                            <label for="partEcole" class="col-lg-3 col-xs-5 col-sm-4 control-label">Part Ecole:</label>
                                            <div class="col-lg-9 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control texte" id="partEcole" name="partEcole" />
                                                    <span class="glyphicon form-control-feedback"></span>
                                            </div>
                                            <span class="help-block col-lg-11 col-xs-10 col-lg-offset-1 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;" id="dangerPartEcole">La part de l'école n'est pas valide</span>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="form-group">
                                            <div class="col-lg-4 col-lg-offset-4">
                                                    <input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
                                                    <input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
                                            </div>
                                    </div>

                                    <div class="modal fade" id="alert" data-backdrop="false">
                                            <div class="modal-dialog">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                    <button class="close" data-dismiss="modal">x</button>
                                                                    <h1 class="modal-title" id="titre-alert"><?php echo $observation; ?> Nouvelle école</h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                    <p id="texte-alert">
                                                                    <?php 
                                                                            if(isset($_COOKIE['nouvelle_ecole']))
                                                                            {
                                                                                    echo $_COOKIE['nouvelle_ecole']; 
                                                                            }
                                                                            else
                                                                            {
                                                                                    echo 'Les données ne sont pas valides';
                                                                            }
                                                                    ?>
                                                                    </p>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </form>
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
		<script src="js/ajouter_ecole.js"></script>
	</body>
</html>