<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5bd06f6b476c2f239ff5c82b/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<nav class="navbar navbar-default">
	<span class="pull-right" style="margin-right: 20px"><?php if(isset($_SESSION['user'])) echo $_SESSION['user']['nom'];?></span>
	
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
			if(isset($_SESSION['user']))
			{
                            
                        if($_SESSION['user']['nom_fonction']=='Enseignant')
			{?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Edition<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                    <li><a href="saisie_note.php">Saisie des notes</a></li>
                            </ul>
			</li>
                        
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Contrôle de présence<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="controle_presence.php">Contrôle élèves</a></li>
                                <li><a href="statistique_presence.php">Statistique des élèves</a></li>
                            </ul>
			</li>
                        <?php
                        }
                        
                        
                        if($_SESSION['user']['nom_fonction']=='Eleve')
			{?>
                        <li><a href="bulletin.php?id=<?php echo $_SESSION['user']['id'];?>">Bulletins</a></li>
                        <?php
                        }
                        
                        
                        if($_SESSION['user']['nom_fonction']=='Parent')
			{?>
                        <li><a href="enfants_tuteur.php">Enfants</a></li>
                        <?php
                        }
                        
			if($_SESSION['user']['nom_fonction']=='Directeur général' || $_SESSION['user']['nom_fonction']=='Proviseur' || $_SESSION['user']['nom_fonction']=='Principal' ||
			$_SESSION['user']['nom_fonction']=='Directeur')
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
			
			<!--<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bibliothèque<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="nouveau_livre.php">Nouveau livre</a></li>
					<li><a href="nouvel_emprunt.php">Nouvel emprunt</a></li>
					<li class="divider"></li>
					<li><a href="recherche_livre.php">Rechercher un livre</a></li>
					<li><a href="liste_livre.php">Liste des livres</a></li>
					<li><a href="liste_emprunt.php">Liste des emprunts</a></li>
				</ul>
			</li>-->
			
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
			
			<?php
			if($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général')
			{
			?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Comptabilité<span class="caret"></span></a>
				<ul class="dropdown-menu">
                                    <li><a href="parametrage_paiement.php">Paramètres paiement</a></li>
                                    <?php
                                    if($_SESSION['user']['nom_fonction']==='Comptable' || $_SESSION['user']['nom_fonction']==='Directeur général')
                                    {?>
					<li><a href="mensualite.php">Mensualité</a></li>
                                    <?php
                                    }
                                    ?>
                                    <li><a href="mensualite_eleve.php">Mensualité par élève</a></li>
                                    <li><a href="mensualite_impaye.php">Mensualité non payée</a></li>
                                    <li><a href="rapport_payement.php">Rapport des payements</a></li>
                                    <li><a href="etat_journalier_paiement.php">Etat journalier</a></li>
                                    <li><a href="controle_paiement.php">Controle de paiement</a></li>
                                    <li class="divider"></li>
                                    <?php
                                    if($_SESSION['user']['nom_fonction']==='Comptable')
                                    {?>
                                    <li><a href="salaire.php">Salaire</a></li>
                                    <?php
                                    }
                                    ?>
                                    <li><a href="rapport_salaire.php">Rapport salaire</a></li>
                                    
                                    <?php
                                    if($_SESSION['user']['nom_fonction']==='Comptable')
                                    {?>
                                    <li><a href="faire_bon.php">Faire un bon</a></li>
                                    <?php
                                    }
                                    ?>
                                    
                                    <li><a href="liste_bon.php">Liste des bons</a></li>
                                    <li><a href="rapport_comptabilite.php">Rapport Comptabilité</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dépenses<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="categorie_depense.php">Catégorie dépense</a></li>
					<li><a href="nouvelle_depense.php">Nouvelle dépense</a></li>
					<li><a href="liste_depense.php">Liste des dépenses</a></li>
				</ul>
			</li>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user']['nom_fonction']=='Super Administrateur')
			{?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration<span class="caret"></span></a>
				<ul class="dropdown-menu">
					
					<li><a href="ajouter_region.php">Ajouter Département</a></li>
					<li><a href="ajouter_prefecture.php">Ajouter Commune</a></li>
					<li><a href="liste_prefecture.php">Liste commune</a></li>
					<li class="divider"></li>
					<li><a href="ajouter_utilisateur.php">Ajouter un utilisateur</a></li>
					<li><a href="liste_utilisateur.php">Liste des utilisateurs</a></li>
					<li class="divider"></li>
					<li><a href="rapport_connexion.php">Rapport connexion</a></li>
				</ul>
			</li>
			<?php
			}
			?>
			
			<?php
			if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='Responsable Régionale' || $_SESSION['user']['nom_fonction']=='DPE / DCE' ||
			$_SESSION['user']['nom_fonction']=='Partenaire')
			{?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ecoles<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="partenaires.php">Afficher les Ecoles</a></li>
					<?php
					if($_SESSION['user']['nom_fonction']=='Super Administrateur' || $_SESSION['user']['nom_fonction']=='DPE / DCE')
					{?>
					<li><a href="ajouter_ecole.php">Ajouter une ecole</a></li>
					<?php
					}
					?>
					<li><a href="statistique_enseignant.php">Statistique des enseignants</a></li>
				</ul>
			</li>
			<?php
			}
			?>
                        
                        <?php
                        if($_SESSION['user']['nom_fonction']==='DRH')
                        {?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Personnel<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                    <li><a href="inscription_personnel.php">Inscrire un personnel</a></li>				
                                    <li><a href="liste_personnel_gov.php">Afficher le personnel</a></li>
                            </ul>
			</li>
                        <?php
                        }
                        ?>
			
			<li><a href="deconnexion.php">Deconnexion</a></li>
			
			<?php
			}
			?>
		<ul>
	</div>
</nav>