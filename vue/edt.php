<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>EDT</title>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link rel="icon" href="fonts/glyphicons-halflings-regular.woff" />
        <link href="css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
                <?php 
                    include_once('controle/entete.php');
                    include_once('modele/fonctionsEDT.php');
                    if(isset($_GET['idClasse'])){
                        $idClasse=$_GET['idClasse'];
                    }
                ?>
        </header>

        <div class="container">
            <?php
                if (isset($idClasse)){
                    echo afficheEmploie($idClasse);
                }else{
                    echo 'La classe n\'a pas été authentifiée correctement. Veuillez en informer le responsable informatique de l\'application';
                }
            ?>
        </div>

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/resultats.js"></script>
    </body>
</html>