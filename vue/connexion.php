<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>VISION COLLEGE</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		
		<header>
			<?php include_once('controle/entete.php'); ?>
		</header>
		
		<div class="container">
			<div class="row">
				<form method="post" class="well form-horizontal col-lg-6 col-lg-offset-3 col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1">
					<?php
					if(isset($_COOKIE['echec_connexion']))
					{?>
						<p class="col-lg-6 col-lg-offset-3"><span class="label label-danger">Le login ou le mot de passe est incorrect</span></p>
					<?php
					}
					?>
					
					<div class="form-group has-feedback">
						<div class="col-lg-8 col-xs-7 col-sm-8">
                                                    <input type="hidden" class="form-control texte" id="login" name="type" value="<?php echo $type;?>" />
						</div>
					</div>
                                                
                                        <?php
					if($type=='parents_eleves')
					{?>
                                            <div class="form-group has-feedback">
                                                <div class="col-lg-8 col-xs-7 col-sm-8 col-lg-offset-4 col-xs-offset-5 col-sm-offset-4">
                                                    <input type="radio" id="parent" name="parent_eleve" value="parent" checked="checked"/>
                                                    <label for="parent" class="control-label">Parent</label>

                                                    <input type="radio" id="eleve" name="parent_eleve" value="eleve"/>
                                                    <label for="eleve" class="control-label">Elève</label>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
					
					<div class="form-group has-feedback">
                                            <label for="login" class="col-lg-4 col-xs-5 col-sm-4 control-label"><?php echo $libelleLogin;?></label>
                                            <div class="col-lg-8 col-xs-7 col-sm-8">
                                                    <input type="text" class="form-control texte" id="login" name="login" />
                                            </div>
					</div>
					
					<div class="form-group has-feedback">
                                            <label for="passe" class="col-lg-4 col-xs-5 col-sm-4 control-label">Mot de passe:</label>
                                            <div class="col-lg-8 col-xs-7 col-sm-8">
                                                    <input type="password" class="form-control texte" id="passe" name="passe" />
                                            </div>
					</div>
					
					<?php
					if($type=='enseignants' || $type=='parents_eleves')
					{?>
                                            <div class="form-group has-feedback">
                                                <label for="ecole" class="col-lg-4 col-xs-5 col-sm-4 control-label">Ecole:</label>
                                                <div class="col-lg-8 col-xs-7 col-sm-8">
                                                        <select class="form-control texte" id="ecole" name="ecole">
                                                                <?php
                                                                foreach($listeEcole as $ecole)
                                                                {?>
                                                                        <option value="<?php echo $ecole['id'];?>"><?php echo $ecole['nom'];?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                        </select>
                                                </div>
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
				</form>
			</div>
		</div>
		
		<?php include_once('pied_page.php'); ?>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>