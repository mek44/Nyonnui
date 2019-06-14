$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$form=$('#form-inscription'),
		$nom=$('#nom'),
		$matricule=$('#matricule'),
		$prenom=$('#prenom'),
		$jourNaissance=$('#jourNaissance'),
		$moisNaissance=$('#moisNaissance'),
		$anneeNaissance=$('#anneeNaissance'),
		$lieuNaissance=$('#lieuNaissance'),
		$pere=$('#pere'),
		$mere=$('#mere'),
		$nomTuteur=$('#nomTuteur'),
		$adresse=$('#adresse'),
		$telephone=$('#telephone'),
		$jourInscription=$('#jourInscription'),
		$moisInscription=$('#moisInscription'),
		$anneeInscription=$('#anneeInscription'),
		$salaire=$('#salaire'),
		$taux=$('#taux'),
		$texte=$('.texte');
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