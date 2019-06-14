<?php 
    session_start();
    include('new/setup/abonnes.php'); 
    include('new/getEcole.php');
    $listeEcoles = getEcole();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NYONNUI</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
  <link rel="stylesheet" type="text/css" href="new/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="new/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="new/css/imagehover.min.css">
  <link rel="stylesheet" type="text/css" href="new/css/style.css">
  <link href="new/img/logo.jpg" rel="icon">
  
</head>

<body>
  <!--Navigation bar-->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">CJSFB</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#feature">A Propos</a></li>
          <!---<li><a href="#organisations">Organisations</a></li> -->
          <!--- <li><a href="#courses">Courses</a></li>  -->
          <!---<li><a href="#pricing">Pricing</a></li>  -->
          <li><a id='connexion' href="#" data-target="#logindiv" data-toggle="modal">Connexion</a></li>
          <!---<li class="btn-trial"><a href="#footer">Free Trail</a></li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Navigation bar-->
  <!--Modal box-->
  <div class="modal fade" id="logindiv" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content no 1-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center form-title">Login</h4>
        </div>
        <div class="modal-body padtrbl">

          <div class="login-box-body">
            <p class="login-box-msg" id="loginMsg">Connectez vous pour démarrer votre session</p>
            <div class="form-group">
              <form action="connexion.php" id="loginForm" method="POST">
                <div class="form-group">
                  <!----- Function or role  -------------->
                  <select class="form-control" placeholder="role utilisateur" id="type" name="type" type="text" autocomplete="off" />
                    <option value="admin_compta" >Administration Comptable</option>
                    <option value="enseignants">Enseignants</option>
                    <option value="eleves">Eleves</option>
                    <option value="parents">Parents</option>
                    <option value="partenaires">Partenaires</option>
                  </select>
                  <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_type"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <!----- username -------------->
                  <input class="form-control" placeholder="Nom utilisateur" id="login" name="login" type="text" autocomplete="off" />
                  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <!----- password -------------->
                  <input class="form-control" placeholder="Mot de passe" id="passe" name="passe" type="password" autocomplete="off" />
                  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                  <div class="form-group">
                  <!----- Liste des écoles  -------------->
                  <select class="form-control" placeholder="Nom ecole" id="ecole" name="ecole" type="text" autocomplete="on" disabled/>
                 <?php
				  	foreach($listeEcoles as $ecole) {
				  ?>
                  <option value="<?php echo $ecole['id']?>"><?php echo $ecole['nom']?></option>
                  <?php } ?>
                  </select>
                  <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_type"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="row">
                  <div class="col-xs-12">
                    <div class="checkbox icheck">
                      <label>
                                <input type="checkbox" id="loginrem" > Se rappeler de moi
                              </label>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button type="button" class="btn btn-green btn-block btn-flat" name="login">Connexion</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!--/ Modal box-->
  <!--Banner-->
  <div class="banner">
    <div class="bg-color">
      <div class="container">
        <div class="row">
          <div class="banner-text text-center">
            <div class="text-border">
              <h2 class="text-dec">Nyonnui</h2>
            </div>
            <div class="intro-para text-center quote">
              <p class="big-text">Gérez votre établissement le plus simple que possible</p>
              <p class="small-text">Votre plateforme électronique de gestion des établissements d\'enseignement public et privé</p>
              <a href="" class="btn get-quote" mailto="c1r1t@cjsfb.online">Contactez nous</a>
            </div>
            <a href="#feature" class="mouse-hover">
              <div class="mouse"></div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Banner-->
  <!--Feature-->
  <section id="feature" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h2></h2>
          <p>NYONNUI une application web qui permet aux entités impliquées dans la gestion et le suivi scolaire de consulter, imprimer et modifier toutes informations d&apos;un établissement scolaire en ligne à tavers internet </p>
          <hr class="bottom-line">
        </div>
        <div class="feature-info">
          <div class="fea">
            <div class="col-md-4">
              <div class="heading pull-right">
                <h4>Une application complètement dédiée à l'usage académique</h4>
                <p>NYONNUI est une application web pour votre école et un site à accès restreint pour les parents, les enseignants et le personnel de l'école, disponible 24h/24 et 7j/7. Elle représente un véritable environement de partage et d'échange autour de la vie scolaire.</p>
              </div>
              <div class="fea-img pull-left">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>
          <div class="fea">
            <div class="col-md-4">
              <div class="heading pull-right">
                <h4>Portez un regard nouveau sur les établissements</h4>
                <p>Avec NYONNUI chacun est appelé à porter un regard nouveau sur l'établissement. Grâce à un tableau de bord  facile à prendre en main, graphes, et suivi pluriannuel disponible en un clic, vous avez la possibilité de consulté en record aux informations rélatives à la gestion de votre établissement</p>
              </div>
              <div class="fea-img pull-left">
                <i class="fa fa-graduation-cap"></i>
              </div>
            </div>
          </div>
          <div class="fea">
            <div class="col-md-4">
              <div class="heading pull-right">
                <h4>Une solution économique, simple et rentable</h4>
                <p>L'acquisition d'un site vitrine et une application de suivie scolaire, avec une interface qui ne nécessite aucune formation au préalable, et en interagissant avec le monde exterieur, NYONNUI reduit considérablement le coût de gestion de votre école et par élève.</p>
              </div>
              <div class="fea-img pull-left">
                <i class="fa fa-adjust"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ feature-->
 
  <!--abonnement-->
  <section id="cta-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="text-center">Abonement</h2>
          <p class="cta-2-txt">Abonnez-vous maintenant et vous recevrez régulièrement les nouvelles de NYONNUI. Vous allez adorer.</p>
          <div class="cta-2-form text-center">
            <form method="POST" id="workshop-newsletter-form">
              <input name="email" placeholder="Entrez votre adresse email ici..." name="email" type="email">
              <input class="cta-2-form-submit-btn" value="Abonnez" name="subscribe" type="submit">
            </form> <br>
            <?php 
              if (isset($error)) {
                echo '<font color="red">'.$error."</font>";
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ abonnement-->

  <!--work-shop-->
  <section id="work-shop" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h2>Fonctionnalités NYONNUI</h2>
          <hr class="bottom-line">
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="thumbnail">
            <img src="new/img/enseignants.png" alt="enseignants" class="ImgFonctionnalites" width="129" height="129">
            <div class="" style="text-align: center;">
              <p><strong>Niveau enseignant</strong></p>
            </div>
            <div class="testblock">
            <ul>
              <li class="fa fa-check">Notification d'absence de l'élève</li>
              <li class="fa fa-check">gestion automatique des bulletins de notes</li>
              <li class="fa fa-check">Gestion de l'emploi du temps</li>
              <li class="fa fa-check">Notification d'absence de l'enseignant</li>
              <li class="fa fa-check">Salaire de mensuel et annuel de l'enseigant</li>
              <li class="fa fa-check">Gestion du cahier de texte</li>
              <li class="fa fa-check">Remarques concernant l'élève</li>
            </ul>
          </div>
            
            
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="thumbnail">
            <img src="new/img/administration.png" alt="administration" class="ImgFonctionnalites" width="129" height="129">
            <div class="" style="text-align: center;">
              <p><strong>Niveau administratif</strong></p>
            </div>
            <div class="testblock">
            <ul>
              <li class="fa fa-check">Gestion du dossier de l’élève</li>
              <li class="fa fa-check">Gestion professeurs</li><br>
              <li class="fa fa-check">Gestion du personnels</li>
              <li class="fa fa-check">Gestion des salles et des équipements</li>
              <li class="fa fa-check">Gestion des séances</li><br>
              <li class="fa fa-check">Gestion des classes</li>
              <li class="fa fa-check">Gestion des certificats scolaire</li>
            </ul>
          </div>

          </div>
        </div>
        <div class="col-md-4 col-sm-6">
           <div class="thumbnail">
            <img src="new/img/parents.png" alt="parents" class="ImgFonctionnalites" width="129" height="129">
            <div class="" style="text-align: center;">
              <p><strong>Niveau Parent</strong></p>
            </div>
            <div class="testblock">
            <ul>
                  <li class="fa fa-check"> Consultation de l'emploi du temps</li>
                  <li class="fa fa-check">Consultation des absences</li>
                  <li class="fa fa-check">Consultation des notes par matières </li>
                  <li class="fa fa-check">Contact permanent avec l'école grâce au Emailing</li>
                  <li class="fa fa-check">Espace d'information sur l'école et l'enfant</li>
                  <li class="fa fa-check">Avis des parents sur la gestion interne du collège.</li>
            </ul>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ work-shop-->

<!--Testimonial-->
  <section id="testimonial" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h2 class="white">Qu'en pense certains de nos Utilisateurs</h2>
          
          <hr class="bottom-line bg-white">
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="text-comment">
            <p class="text-par">"Prémière plateforme de gestion de collège au Bénin. Elle répond aux besoins et exigences actuelles du marché béninois. Très flexible, et facile à prendre en main. En plus j'ai la facilité de faire mon point financier en deux, trois clics. NYONNUI, elle me simplifie la vie"</p>
            <p class="text-name">Juliette AKABI - Comptable d'Etablissement Privée</p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="text-comment">
            <p class="text-par">"Plusieurs options sont possible avec cette application. Facilité d'administrer mon établissement sur on smartphone, depuis ma maison. Elle s'adapte aussi bien aux débit des forfaits internets. pas de Beurg, pas de complication. J'adore NYONNUI."</p>
            <p class="text-name">Jean ADA - Dırecteur d'Etablissement privée</p>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!--/ Testimonial-->
  


  <!--Faculity member-->
  <!--- <section id="faculity-member" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h2>Meet Our Faculty Member</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem nesciunt vitae,<br> maiores, magni dolorum aliquam.</p>
          <hr class="bottom-line">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="pm-staff-profile-container">
            <div class="pm-staff-profile-image-wrapper text-center">
              <div class="pm-staff-profile-image">
                <img src="img/mentor.jpg" alt="" class="img-thumbnail img-circle" />
              </div>
            </div>
            <div class="pm-staff-profile-details text-center">
              <p class="pm-staff-profile-name">Bryan Johnson</p>
              <p class="pm-staff-profile-title">Lead Software Engineer</p>

              <p class="pm-staff-profile-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et placerat dui. In posuere metus et elit placerat tristique. Maecenas eu est in sem ullamcorper tincidunt. </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="pm-staff-profile-container">
            <div class="pm-staff-profile-image-wrapper text-center">
              <div class="pm-staff-profile-image">
                <img src="img/mentor.jpg" alt="" class="img-thumbnail img-circle" />
              </div>
            </div>
            <div class="pm-staff-profile-details text-center">
              <p class="pm-staff-profile-name">Bryan Johnson</p>
              <p class="pm-staff-profile-title">Lead Software Engineer</p>

              <p class="pm-staff-profile-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et placerat dui. In posuere metus et elit placerat tristique. Maecenas eu est in sem ullamcorper tincidunt. </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="pm-staff-profile-container">
            <div class="pm-staff-profile-image-wrapper text-center">
              <div class="pm-staff-profile-image">
                <img src="img/mentor.jpg" alt="" class="img-thumbnail img-circle" />
              </div>
            </div>
            <div class="pm-staff-profile-details text-center">
              <p class="pm-staff-profile-name">Bryan Johnson</p>
              <p class="pm-staff-profile-title">Lead Software Engineer</p>

              <p class="pm-staff-profile-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et placerat dui. In posuere metus et elit placerat tristique. Maecenas eu est in sem ullamcorper tincidunt. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Faculity member-->
  
  
  <!--Footer-->
  <footer id="footer" class="footer">
    <div class="container text-center">
      <p class="white">Club des Jeunes Scientifiques Francophones du Bénin Siège: Armand ATTA - Wibatin - Sékou</p><br>
      <p class="white"> Contact: +229 61 22 22 71 - 61 20 20 22 / +33 618 138 645</p>
      <p class="white">Email: contact@cjsfb.online</p>
      <!-- End newsletter-form -->
      <ul class="social-links">
        <li><a href="https://web.facebook.com/search/top/?q=cjsfb"><i class="fa fa-facebook fa-fw"></i></a></li>
        <li><a href="https://plus.google.com/u/0/106464262569531462848"><i class="fa fa-google-plus fa-fw"></i></a></li>
        <li><a href="#link"><i class="fa fa-linkedin fa-fw"></i></a></li>
      </ul>
      ©2018 NYONNUI. Tous droits réservés
      <div class="credits">
       
        Propulsé par <a href="http://cjsfb.online/"> CJSFB</a>
      </div>
    </div>
  </footer>
  <!--/ Footer-->

  <script src="new/js/jquery.min.js"></script>
  <script src="new/js/jquery.easing.min.js"></script>
  <script src="new/js/bootstrap.min.js"></script>
  <script src="new/js/custom.js"></script>
  <script type="text/javascript">
      var status="<?php echo filter_input(INPUT_GET,'status')?>";
      if(status==='failed'){$("#connexion").get(0).click();}
  </script>
</body>

</html>
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>