<nav class="navbar navbar-default">
	<span class="pull-right" style="margin-right: 20px"><?php echo $_SESSION['user']['nom'];?></span>
	
	<div class="navbar-header">
		<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	
	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="index.php" class="active">Accueil</a></li>
			
			<?php
			if($_SESSION['user']['fonction']=='directeur')
			{?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ajouter<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="inscription.php">Inscription</a></li>
					<li><a href="reinscription.php">Réinscription</a></li>
					<li class="divider"></li>
					<li><a href="recrutement.php">Récrutement & Affectation</a></li>
					<li><a href="nouvelle_matiere.php">Nouvelle matière</a></li>
					<li><a href="nouvelle_classe.php">Nouvelle classe</a></li>
					<li><a href="nouveau_service.php">Nouveau service</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Edition<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="saisie_note.php">Saisie des notes</a></li>
					<li class="divider"></li>
					<li><a href="modifier_eleve.php">Modifier un élève</a></li>
					<li><a href="modifier_professeur.php">Modifier un Professeur</a></li>
					<li class="divider"></li>
					<li><a href="modifier_classe.php">Modifier une classe</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Affichage<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="resultats.php">Résultats</a></li>
					<li class="divider"></li>
					<li><a href="liste_eleve.php">Liste des élèves</a></li>
					<li><a href="liste_personnel.php">Liste du personnel</a></li>
					<li class="divider"></li>
					<li><a href="liste_classe.php">Liste des classes</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Comptabilité<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="mensualite.php">Mensualité</a></li>
					<li><a href="mensualite_eleve.php">Mensualité par élève</a></li>
					<li><a href="mensualite_impaye.php">Mensualité non payée</a></li>
					<li><a href="rapport_payement.php">Rapport des payements</a></li>
					<li class="divider"></li>
					<li><a href="salaire.php">Salaire</a></li>
					<li><a href="rapport_salaire.php">Rapport salaire</a></li>
					<li><a href="faire_bon.php">Faire un bon</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bibliothèque<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="nouveau_livre.php">Nouveau livre</a></li>
					<li><a href="nouvel_emprunt.php">Nouvel emprunt</a></li>
					<li class="divider"></li>
					<li><a href="recherche_livre.php">Rechercher un livre</a></li>
					<li><a href="liste_livre.php">Liste des livres</a></li>
					<li><a href="liste_emprunt.php">Liste des emprunts</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dépenses<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="nouvelle_depense.php">Nouvelle dépense</a></li>
					<li><a href="liste_depense.php">Liste des dépenses</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Contrôle de présence<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="controle_presence.php">Contrôle élèves</a></li>
					<li><a href="statistique_presence.php">Statistique des élèves</a></li>
					<li class="divider"></li>
					<li><a href="controle_enseignant.php">Contrôle des enseignants</a></li>
					<li><a href="statistique_enseignant.php">Statistique des enseignants</a></li>
				</ul>
			</li>
			<?php
			}
			?>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php
					if($_SESSION['user']['fonction']!='directeur')
					{?>
					<li class="divider"></li>
					<li><a href="ajouter_utilisateur.php">Ajouter un utilisateur</a></li>
					<li><a href="liste_utilisateur.php">Liste des utilisateurs</a></li>
					<li class="divider"></li>
					<?php
					}
					?>
					
					<?php
					if($_SESSION['user']['fonction']=='directeur')
					{?>
						<li><a href="rapport_comptabilite.php">Rapport Comptabilité</a></li>
					<?php
					}
					?>
					
					<li><a href="rapport_connexion.php">Rapport connexion</a></li>
				</ul>
			</li>
			
			<?php
			if($_SESSION['user']['fonction']!='directeur')
			{?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ecoles<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="partenaires.php">Afficher les Ecoles</a></li>
					<li><a href="ajouter_ecole.php">Ajouter une ecole</a></li>
					<li><a href="statistique_enseignant.php">Statistique des enseignants</a></li>
				</ul>
			</li>
			<?php
			}
			?>
		<ul>
	</div>
</nav>