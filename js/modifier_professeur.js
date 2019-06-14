$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$form=$('#form-inscription'),
		$nom=$('#nom'),
		$recherche=$('#recherche'),
		$matricule=$('#matricule'),
		$prenom=$('#prenom'),
		$jourNaissance=$('#jourNaissance'),
		$moisNaissance=$('#moisNaissance'),
		$anneeNaissance=$('#anneeNaissance'),
		$lieuNaissance=$('#lieuNaissance'),
		$adresse=$('#adresse'),
		$telephone=$('#telephone'),
		$image=$('#image'),
		$jourInscription=$('#jourInscription'),
		$moisInscription=$('#moisInscription'),
		$anneeInscription=$('#anneeInscription'),
		$fonction=$('#fonction'),
		$salaire=$('#salaire'),
		$taux=$('#taux'),
		$texte=$('.texte'),
		$passe=$('#passe'),
		$code=$('#code'),
		$envoyer=$('#envoyer');
	
	if(/succes/.test($titreAlert.text()))
	{
		$('.modal-content').removeClass('echec');
		$('.modal-content').addClass('succes');
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	else if(/echec/.test($titreAlert.text()))
	{
		$('.modal-content').removeClass('succes');
		$('.modal-content').addClass('echec');
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	
	$recherche.keyup(function(e){
		var valeur=encodeURIComponent($(this).val());
		
		$matricule.val('');
		$nom.val('');
		$prenom.val('');
		$('#sexe option:eq(0)').prop('selected', true);
		$jourNaissance.val('');
		$moisNaissance.val('');
		$anneeNaissance.val('');
		$lieuNaissance.val('');
		$image.attr('src', '');
		$adresse.val('');
		$telephone.val('');
		$jourInscription.val('');
		$moisInscription.val('');
		$anneeInscription.val('');
		$fonction.text('');
		$salaire.text('');
		$taux.text('');
		
		$.get(
			'modele/get_infos_professeur.php',
			'matricule='+valeur,
			function(data){
				$matricule.val(data.matricule);
				$nom.val(data.nom);
				$prenom.val(data.prenom);
				$('#sexe option[value="'+data.sexe+'"]').prop('selected', true);
				$jourNaissance.val(data.jour);
				$moisNaissance.val(data.mois);
				$anneeNaissance.val(data.annee);
				$lieuNaissance.val(data.lieu_naissance);
				$image.attr('src', 'imagespersonnel/'+data.photo);
				$adresse.val(data.quartier);
				$telephone.val(data.telephone);
				$jourInscription.val(data.jour_ins);
				$moisInscription.val(data.mois_ins);
				$anneeInscription.val(data.annee_ins);
				$salaire.val(data.salaire);
				$taux.val(data.taux);
				$fonction.val(data.fonction);
				$code.val(data.code);
			},
			'json'
		);
		
	});
	
	
						
	$texte.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationTexte($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
				
	$jourNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
		var parent=$(this).parent().parent();
		if(verificationJour($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});
	
	$moisNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
		var parent=$(this).parent().parent();
		if(verificationMois($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	$anneeNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
		var parent=$(this).parent().parent();
		if(verificationAnnee($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	$telephone.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationPhone($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
	
	$jourInscription.blur(function(){
		var $alert=$('#dangerDateIns');
		var parent=$(this).parent().parent();
		if(verificationJour($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});
	
	$moisInscription.blur(function(){
		var $alert=$('#dangerDateIns');
		var parent=$(this).parent().parent();
		if(verificationMois($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	$anneeInscription.blur(function(){
		var $alert=$('#dangerDateIns');
		var parent=$(this).parent().parent();
		if(verificationAnnee($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});
	
	$salaire.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationMontant($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
	
	$taux.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationMontant($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
	
	
					
	$envoyer.click(function(e){
		var ok=true;
		$texte.each(function(){
			ok=ok && verificationTexte($(this));
		});
		
		ok=ok && verificationJour($jourNaissance);
		ok=ok && verificationMois($moisNaissance);
		ok=ok && verificationAnnee($anneeNaissance);
		ok=ok && verificationPhone($telephone);
		ok=ok && verificationJour($jourInscription);
		ok=ok && verificationMois($moisInscription);
		ok=ok && verificationAnnee($anneeInscription);
		ok=ok && verificationMontant($salaire);
		ok=ok && verificationMontant($taux);
		
		if(!ok){
			e.preventDefault();
			$('.modal-content').removeClass('succes');
			$('.modal-content').addClass('echec');
			$alertDialog.modal('show');
			
			setTimeout(function(){
				$alertDialog.modal('hide');
			}, 3000);
			}
	});
		
	function verificationTexte(champ){
		if(champ.val().length>1)
			return true;
		else
			return false;
	}
	
	
	function verificationPhone(champ){
		if(/^[0-9][-0-9. ]+$/.test(champ.val())){
			return true;
		}else{
			return false;
		}
	}
	
	function verificationJour(champ){
		var jour=parseInt(champ.val());
		
		if(/^[0-9]{1,2}/.test(champ.val()) && jour>0 && jour<32){
			return true;
		}else{
			return false;
		}
	}
	
	function verificationMois(champ){
		var mois=parseInt(champ.val());
		
		if(/^[0-9]{1,2}/.test(champ.val()) && mois>0 && mois<13){
			return true;
		}else{
			return false;
		}
	}
	
	function verificationAnnee(champ){
		if(/^[0-9]{4}/.test(champ.val())){
			return true;
		}else{
			return false;
		}
	}
	
	function verificationMontant(champ){
		var valeur=parseInt(champ.val());
		
		if(/^[0-9]+/.test(champ.val())){
			return true;
		}else{
			return false;
		}
	}
});