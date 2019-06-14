<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Faire un bon</title>
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
			<h1 class="col-lg-12" style="text-align: center;">Payer un bon</h1>
			<div class="row saut">
				<form method="post" class="well form-horizontal col-lg-7 col-xs-12 col-sm-12">	
                                    <fieldset>
                                        <legend>Informations du personnel</legend>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label for="matricule" class="col-lg-5 col-xs-5 col-sm-4 control-label">Matricule:</label>
                                                        <div class="col-lg-5 col-xs-7 col-sm-8">
                                                            <input type="text" class="form-control texte" id="matricule" name="matricule" value="<?php echo $info['matricule'];?>" disabled />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nom" class="col-lg-5 col-xs-5 col-sm-4 control-label">Nom:</label>
                                                        <div class="col-lg-7 col-xs-7 col-sm-8">
                                                                <input type="text" class="form-control texte" id="nom" name="nom" value="<?php echo $info['nom'];?>" disabled />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="prenom" class="col-lg-5 col-xs-5 col-sm-4 control-label">Prénom:</label>
                                                        <div class="col-lg-7 col-xs-7 col-sm-8">
                                                                <input type="text" class="form-control texte" id="prenom" name="prenom" value="<?php echo $info['prenom'];?>" disabled />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="telephone" class="col-lg-5 col-xs-5 col-sm-4 control-label">Téléphone:</label>
                                                        <div class="col-lg-7 col-xs-7 col-sm-8">
                                                            <input type="text" class="form-control texte" id="telephone" name="telephone" value="<?php echo $info['telephone'];?>" disabled />
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <img src="imagespersonnel/<?php echo $info['photo'];?>" alt="image" class="img-responsive" id="image" />
                                            </div>
                                        </div>
                                    </fieldset>
				</form>
						
						
				<form class="form-horizontal col-lg-5" method="post">
                                    <fieldset>
                                        <div class="form-group has-feedback">
                                                <label for="montant" class="col-lg-5 col-xs-5 col-sm-4 control-label">Montant:</label>
                                                <div class="col-lg-5 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control" id="montant" name="montant" value="<?php echo formatageMontant($info['montant']);?>" disabled=""/>
                                                    <span class="glyphicon form-control-feedback"></span>
                                                </div>
                                        </div>
                                        
                                        <div class="form-group has-feedback">
                                                <label for="payer" class="col-lg-5 col-xs-5 col-sm-4 control-label">Payer:</label>
                                                <div class="col-lg-5 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control" id="payer" name="payer" value="<?php echo formatageMontant($info['payer']);?>" disabled=""/>
                                                    <span class="glyphicon form-control-feedback"></span>
                                                </div>
                                        </div>
                                        
                                        <div class="form-group has-feedback">
                                                <label for="reste" class="col-lg-5 col-xs-5 col-sm-4 control-label">Reste:</label>
                                                <div class="col-lg-5 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control" id="reste" name="reste" value="<?php echo formatageMontant($info['montant']-$info['payer']);?>" disabled=""/>
                                                    <span class="glyphicon form-control-feedback"></span>
                                                </div>
                                        </div>
                                        
                                        <div class="form-group has-feedback">
                                                <label for="verser" class="col-lg-5 col-xs-5 col-sm-4 control-label">Verser:</label>
                                                <div class="col-lg-5 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control" id="verser" name="verser" />
                                                    <span class="glyphicon form-control-feedback"></span>
                                                </div>
                                                <span class="help-block col-lg-6 col-xs-10 col-lg-offset-5 col-xs-offset-1 col-sm-8 col-sm-offset-2" style="display:none;">Le montant n'est pas valide</span>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-5 col-xs-7 col-sm-8">
                                                <input type="hidden" class="form-control" id="idBon" name="idBon" value="<?php echo $idBon;?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-6 col-lg-offset-3">
                                                    <input type="submit" class="btn btn-success" value="Valider" id="envoyer" />
                                                    <input type="reset" class="btn btn-success" value="Annuler" id="annuler" />
                                            </div>
                                        </div>
                                    </fieldset>
				</form>
			</div>		
								
			<div class="modal fade" id="alert" data-backdrop="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                            <button class="close" data-dismiss="modal">x</button>
                                            <h1 class="modal-title" id="titre-alert"><?php echo $observation; ?></h1>
                                    </div>
                                    <div class="modal-body">
                                        <p id="texte-alert">
                                        <?php 
                                        if(isset($_COOKIE['payer_bon']))
                                        {
                                                echo $_COOKIE['payer_bon']; 
                                        }
                                        else
                                        {
                                            echo 'Les donées ne sont pas valides';
                                        }
                                        ?>
                                        </p>
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
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/payer_bon.js"></script>
	</body>
</html>