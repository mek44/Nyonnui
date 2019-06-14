<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Taux de présence</title>
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
				<h1 style="text-align: center;">Taux de présences des enseignants<br /> <?php echo $ecole;?></h1>

				<?php
				foreach($listeTaux as $taux)
				{?>
				<div class="col-lg-3">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h1 class="panel-title"><?php echo $taux['mois'];?></h1>
						</div>

						<div class="panel-body">
							<?php echo parseReel($taux['taux_presence']);?> %
						</div>
					</div>
				</div>
				<?php
				}
				?>
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
	</body>
</html>
