<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>VISION COLLEGE</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/accueil.js"></script>

	</head>
	
	<body>
	
            <?php
            if(isset($_SESSION['user']))
            {?>
                <header>
                    <?php include_once('controle/entete.php'); ?>
                </header>
             <?php  
            }
            ?>
            
            <div class="container-fluid">
                <div class="row" style="position: absolute;" id="banniere" >
                    <?php
                    if(!isset($_SESSION['user']))
                    {?>
                    <div id="bouton-acces">
                        <div class="row saut-bouton-acces">
                            <div class="col-lg-2 col-lg-offset-3 col-sm-2 col-sm-offset-3 col-xs-10 col-xs-offset-1 saut-bouton-acces">
                                <a href="connexion.php?type=admin_compta" class="btn btn-success btn-block">Accès<br />Administration / Comptabilité</a>
                            </div>

                            <div class="col-lg-2 col-lg-offset-1 col-sm-2 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                                <a href="connexion.php?type=partenaires" class="btn btn-success btn-block">Accès<br />Partenaires Education / DRH</a>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-lg-2 col-lg-offset-3 col-sm-2 col-lg-offset-3 col-xs-10 col-xs-offset-1 saut-bouton-acces">
                                <a href="connexion.php?type=enseignants" class="btn btn-success btn-block">Accès<br />Enseignants</a>
                            </div>

                            <div class="col-lg-2 col-lg-offset-1 col-sm-2 col-lg-offset-1 col-xs-10 col-xs-offset-1">
                                <a href="connexion.php?type=parents_eleves" class="btn btn-success btn-block">Accès<br />Parents / Elèves</a>
                            </div>
                        </div>	
                    </div>
                    <?php
                    }
                    ?>
                    
                    <img src="images/banniere.jpg" class="img-responsive" id="img-banniere" />
                    
                </div>
            </div>

            <script src="js/jquery.js"></script>
            <script src="js/bootstrap.js"></script>
            <script>
                if (window.matchMedia("(max-width: 768px)").matches)
                {
                    $('#bouton-acces a').removeClass('btn-lg');
                    $('#bouton-acces a').addClass('btn-xs');
                } else {
                    $('#bouton-acces a').removeClass('btn-xs');
                    $('#bouton-acces a').addClass('btn-lg');
                }
            </script>
	</body>
</html>